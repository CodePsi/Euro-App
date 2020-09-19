Vue.component('euro-header', {
    template: '#euro-header',
    methods: {
        redirect: function(url) {
            window.location.href = url;
        },
        getODT: function() {
            var win = window.open("/euro_new/printing/" + app.qualificationId + "/odt", '_blank');
            win.focus();
        }
    }
});
Vue.component('modal', {
    template: '#modal-template',
    props: {
        width: String
    },
    methods: {
        getActiveID: function() {
            return app.activeModalValue
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
        qualificationData: [],
        percentOfFullness: 0,
        showInfoEntryModal: false
    },
    created: function () {
        var pathname = window.location.pathname;
        this.qualificationId = pathname.match(/\d+/)[0]; //Getting ID from URL (particularly from URI in this case)
        var request = new HttpRequest();
        request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
            if (request.isRequestSuccessful()) {
                var contentsAndResultsJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                app.percentOfFullness = Math.round(app.calculatePercentOfFullness(contentsAndResultsJSON) * 100);
                app.formOfStudyUA = contentsAndResultsJSON.formOfStudyUA;
                app.formOfStudyEN = contentsAndResultsJSON.formOfStudyEN;
                app.programSpecificationUA = contentsAndResultsJSON.programSpecificationUA;
                app.programSpecificationEN = contentsAndResultsJSON.programSpecificationEN;
                app.knowledgeUnderstandingUA = contentsAndResultsJSON.knowledgeUnderstandingUA;
                app.knowledgeUnderstandingEN = contentsAndResultsJSON.knowledgeUnderstandingEN;
                app.applicationKnowledgeUnderstandingUA = contentsAndResultsJSON.applicationKnowledgeUnderstandingUA;
                app.applicationKnowledgeUnderstandingEN = contentsAndResultsJSON.applicationKnowledgeUnderstandingEN;
                app.makingJudgmentsUA = contentsAndResultsJSON.makingJudgmentsUA;
                app.makingJudgmentsEN = contentsAndResultsJSON.makingJudgmentsEN;
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
        },
        calculatePercentOfFullness: function (data) {
            var countOfEmptyFields = 0;
            Object.keys(data).forEach(function (value) {
                if (data[value] === '') {
                    countOfEmptyFields++;
                }
            });
            var length = Object.keys(data).length;

            return (length - countOfEmptyFields) / length;
        }
    }
});