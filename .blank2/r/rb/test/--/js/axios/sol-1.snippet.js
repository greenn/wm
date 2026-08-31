var params = new URLSearchParams();
params.append('time', 17);

await axios({
    method: 'post',
    url: 'http://yastreb.crm/api/rw/tool-log/after-time',
    data: params,
    headers: { 'content-type': 'application/x-www-form-urlencoded' },
})