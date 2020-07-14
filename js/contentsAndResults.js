Vue.component('euro-header', {
    template: '#euro-header',
    methods: {
        redirect: function(url) {
            window.location.href = url;
        }
    }
});

var app = new Vue({
    el: '#app',
    data: {
        formOfStudyUA: '',
        formOfStudyEN: '',
        programSpecificationUA: '',
        programSpecificationEN: '',
        knowledgeUnderstandingUA: '',
        knowledgeUnderstandingEN: '',
        applicationKnowledgeUnderstandingUA: '',
        applicationKnowledgeUnderstandingEN: '',
        makingJudgmentsUA: '',
        makingJudgmentsEN: '',
        qualificationId: -1,
        qualificationData: []
    },
    created: function () {
        var pathname = window.location.pathname;
        this.qualificationId = pathname.match(/\d+/)[0]; //Getting ID from URL (particularly from URI in this case)
        var request = new HttpRequest();
        request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
            if (request.isRequestSuccessful()) {
                var nationalFrameworkJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                app.formOfStudyUA = nationalFrameworkJSON.formOfStudyUA;
                app.formOfStudyEN = nationalFrameworkJSON.formOfStudyEN;
                app.programSpecificationUA = nationalFrameworkJSON.programSpecificationUA;
                app.programSpecificationEN = nationalFrameworkJSON.programSpecificationEN;
                app.knowledgeUnderstandingUA = nationalFrameworkJSON.knowledgeUnderstandingUA;
                app.knowledgeUnderstandingEN = nationalFrameworkJSON.knowledgeUnderstandingEN;
                app.applicationKnowledgeUnderstandingUA = nationalFrameworkJSON.applicationKnowledgeUnderstandingUA;
                app.applicationKnowledgeUnderstandingEN = nationalFrameworkJSON.applicationKnowledgeUnderstandingEN;
                app.makingJudgmentsUA = nationalFrameworkJSON.makingJudgmentsUA;
                app.makingJudgmentsEN = nationalFrameworkJSON.makingJudgmentsEN;
            }
        };
        request.sendGETRequest("/euro_new/contentsAndResults/" + this.qualificationId, "");
    },
    methods: {
        getContentsAndResults: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    app.qualificationData = JSON.parse(request.xmlHttpRequestInstance.responseText);
                }
            };
            request.sendGETRequest("/euro_new/contentsAndResults/" + app.qualificationId, "");
        },
        updateContentsAndResults: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    console.log(request.xmlHttpRequestInstance.responseText);
                }
            };

            request.sendPUTRequest("/euro_new/contentsAndResults/" + app.qualificationId, JSON.stringify({'formOfStudyUA': app.formOfStudyUA, 'formOfStudyEN': app.formOfStudyEN, 'programSpecificationUA': app.programSpecificationUA,
                'programSpecificationEN': app.programSpecificationEN, 'knowledgeUnderstandingUA': app.knowledgeUnderstandingUA, 'knowledgeUnderstandingEN': app.knowledgeUnderstandingEN, 'applicationKnowledgeUnderstandingUA': app.applicationKnowledgeUnderstandingUA, 'applicationKnowledgeUnderstandingEN': app.applicationKnowledgeUnderstandingEN, 'makingJudgmentsUA': app.makingJudgmentsUA, 'makingJudgmentsEN': app.makingJudgmentsEN}))
        }
    }
});