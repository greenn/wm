
const _Api = (function(){
    axios.defaults.baseURL = '<?=rt('api', 'apiUrl')?>';
    //axios.defaults.headers.post['Content-Type'] = 'application/json';


    return {
        test: function(){

            axios.post('/test', {
                firstName: 'Fred',
                lastName: 'Flintstone'
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                })
            ;

        }
    }

})();