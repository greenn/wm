_vue.providerDep['redirect'] = [
    'redirectTo',
]

_vue.provider.redirectTo = function(addr){
    window.location.href = addr;
}