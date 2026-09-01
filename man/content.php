<?
declare(strict_types=1);

const MAN_MAX_MARKDOWN_BYTES = 524288;

function man_json_response($payload, $status = 200)
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: no-store');
    $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        http_response_code(500);
        print '{"ok":false,"error":{"code":"json-encode-failed","message":"Documentation response unavailable."}}';
        exit;
    }
    print $json;
    exit;
}

function man_error($status, $code, $message)
{
    man_json_response(array(
        'ok' => false,
        'error' => array(
            'code' => $code,
            'message' => $message,
        ),
    ), $status);
}

function man_manifest()
{
    $manifestPath = __DIR__.DIRECTORY_SEPARATOR.'manifest.json';
    $raw = is_file($manifestPath) ? @file_get_contents($manifestPath) : false;
    if ($raw === false) {
        throw new RuntimeException('manifest-unavailable');
    }

    $manifest = json_decode($raw, true);
    if (!is_array($manifest)) {
        throw new RuntimeException('manifest-invalid');
    }

    man_validate_manifest($manifest);

    return $manifest;
}

function man_validate_manifest($manifest)
{
    if (!isset($manifest['site']) || !is_array($manifest['site'])
        || !isset($manifest['site']['title']) || !is_string($manifest['site']['title'])
        || !isset($manifest['site']['defaultDocument']) || !is_string($manifest['site']['defaultDocument'])
        || !isset($manifest['sections']) || !is_array($manifest['sections'])
        || !isset($manifest['documents']) || !is_array($manifest['documents'])) {
        throw new RuntimeException('manifest-schema-invalid');
    }

    foreach ($manifest['documents'] as $id => $document) {
        if (!is_string($id) || !preg_match('~^[a-z0-9][a-z0-9/-]{0,119}$~', $id)
            || !is_array($document)
            || !isset($document['title']) || !is_string($document['title'])
            || !isset($document['status']) || !is_string($document['status'])
            || !isset($document['file']) || !is_string($document['file'])) {
            throw new RuntimeException('manifest-document-invalid');
        }

        foreach (array('tags', 'related', 'pages', 'modules') as $arrayField) {
            if (isset($document[$arrayField]) && !is_array($document[$arrayField])) {
                throw new RuntimeException('manifest-document-array-invalid');
            }
        }

        if (isset($document['aside']) && !is_string($document['aside'])) {
            throw new RuntimeException('manifest-document-aside-invalid');
        }
    }

    if (!isset($manifest['documents'][$manifest['site']['defaultDocument']])) {
        throw new RuntimeException('manifest-default-document-invalid');
    }

    foreach ($manifest['sections'] as $section) {
        if (!is_array($section)
            || !isset($section['id']) || !is_string($section['id'])
            || !isset($section['title']) || !is_string($section['title'])
            || !isset($section['items']) || !is_array($section['items'])) {
            throw new RuntimeException('manifest-section-invalid');
        }

        foreach ($section['items'] as $documentId) {
            if (!is_string($documentId) || !isset($manifest['documents'][$documentId])) {
                throw new RuntimeException('manifest-navigation-invalid');
            }
        }
    }
}

function man_public_manifest($manifest)
{
    foreach ($manifest['documents'] as $id => $document) {
        unset($document['file'], $document['aside']);
        $manifest['documents'][$id] = $document;
    }

    return $manifest;
}

function man_read_markdown($relativePath)
{
    if (!is_string($relativePath) || $relativePath === '' || substr($relativePath, -3) !== '.md') {
        throw new RuntimeException('content-path-invalid');
    }

    $root = realpath(__DIR__);
    $candidate = __DIR__.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    $realPath = realpath($candidate);
    $rootPrefix = $root.DIRECTORY_SEPARATOR;

    if ($root === false || $realPath === false || strpos($realPath, $rootPrefix) !== 0 || !is_file($realPath)) {
        throw new RuntimeException('content-not-found');
    }

    $size = @filesize($realPath);
    if ($size === false || $size > MAN_MAX_MARKDOWN_BYTES) {
        throw new RuntimeException('content-size-invalid');
    }

    $markdown = @file_get_contents($realPath);
    if ($markdown === false) {
        throw new RuntimeException('content-unreadable');
    }

    return $markdown;
}

try {
    $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? (string)$_SERVER['REQUEST_METHOD'] : 'GET';
    if ($requestMethod !== 'GET') {
        header('Allow: GET');
        man_error(405, 'method-not-allowed', 'Documentation API поддерживает только GET.');
    }

    $manifest = man_manifest();
    $action = isset($_GET['action']) && is_string($_GET['action']) ? $_GET['action'] : '';

    if ($action === 'manifest') {
        man_json_response(array(
            'ok' => true,
            'manifest' => man_public_manifest($manifest),
        ));
    }

    $documentId = isset($_GET['doc']) && is_string($_GET['doc']) ? $_GET['doc'] : '';
    if (!preg_match('~^[a-z0-9][a-z0-9/-]{0,119}$~', $documentId)) {
        man_error(400, 'invalid-document-id', 'Некорректный идентификатор документа.');
    }

    if (!isset($manifest['documents'][$documentId])) {
        man_error(404, 'document-not-found', 'Документ не найден в карте man.');
    }

    $document = $manifest['documents'][$documentId];
    $markdown = man_read_markdown(isset($document['file']) ? $document['file'] : '');
    $asideMarkdown = '';
    if (!empty($document['aside'])) {
        $asideMarkdown = man_read_markdown($document['aside']);
    }

    unset($document['file'], $document['aside']);
    man_json_response(array(
        'ok' => true,
        'id' => $documentId,
        'document' => $document,
        'markdown' => $markdown,
        'asideMarkdown' => $asideMarkdown,
    ));
} catch (Throwable $error) {
    error_log('[WM man] '.$error->getMessage());
    man_error(500, 'documentation-unavailable', 'Документация временно недоступна.');
}
