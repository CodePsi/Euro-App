var app = new Vue({
    el: '#app',
    data: {
        login: '',
        password: '',
        warning: {
            display: 'none',
            color: 'red'
        }
    },
    methods: {
        logIn: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function () {
                if (request.isRequestSuccessful()) {
                    var response = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    if (response['response'] === "Success")
                    window.location.href = "/euro_new/control-page";
                } else if (request.xmlHttpRequestInstance.status === 401){
                    // app.warning.display = 'block';
                }
            };
            request.sendPOSTRequest("/euro_new/login/authorization", JSON.stringify({ 'login': this.login, 'password': this.password }));
        },
        loc: function () {
            // console.log(document.cookie);
            // location.reload();
            document.location = "menu";
        }
    }
});