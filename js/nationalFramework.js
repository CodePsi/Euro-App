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
        levelOfQualificationUA: '',
        levelOfQualificationEN: '',
        officialDurationProgrammeUA: '',
        officialDurationProgrammeEN: '',
        accessRequirementsUA: '',
        accessRequirementsEN: '',
        accessFurtherStudyUA: '',
        accessFurtherStudyEN: '',
        professionalStatusUA: '',
        professionalStatusEN: '',
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
                var nationalFrameworkJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                app.percentOfFullness = Math.round(app.calculatePercentOfFullness(nationalFrameworkJSON) * 100);
                app.levelOfQualificationUA = nationalFrameworkJSON.levelOfQualificationUA;
                app.levelOfQualificationEN = nationalFrameworkJSON.levelOfQualificationEN;
                app.officialDurationProgrammeUA = nationalFrameworkJSON.officialDurationProgrammeUA;
                app.officialDurationProgrammeEN = nationalFrameworkJSON.officialDurationProgrammeEN;
                app.accessRequirementsUA = nationalFrameworkJSON.accessRequirementsUA;
                app.accessRequirementsEN = nationalFrameworkJSON.accessRequirementsEN;
                app.accessFurtherStudyUA = nationalFrameworkJSON.accessFurtherStudyUA;
                app.accessFurtherStudyEN = nationalFrameworkJSON.accessFurtherStudyEN;
                app.professionalStatusUA = nationalFrameworkJSON.professionalStatusUA;
                app.professionalStatusEN = nationalFrameworkJSON.professionalStatusEN;
            }
        };
        request.sendGETRequest("/euro_new/nationalFrameworks/" + this.qualificationId, "");
    },
    methods: {
        getNationalFramework: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    app.qualificationData = JSON.parse(request.xmlHttpRequestInstance.responseText);
                }
            };
            request.sendGETRequest("/euro_new/nationalFrameworks/" + app.qualificationId, "");
        },
        updateNationalFramework: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    console.log(request.xmlHttpRequestInstance.responseText);
                }
            };

            request.sendPUTRequest("/euro_new/nationalFrameworks/" + app.qualificationId, JSON.stringify({'levelOfQualificationUA': app.levelOfQualificationUA, 'levelOfQualificationEN': app.levelOfQualificationEN, 'officialDurationProgrammeUA': app.officialDurationProgrammeUA,
                'officialDurationProgrammeEN': app.officialDurationProgrammeEN, 'accessRequirementsUA': app.accessRequirementsUA, 'accessRequirementsEN': app.accessRequirementsEN, 'accessFurtherStudyUA': app.accessFurtherStudyUA, 'accessFurtherStudyEN': app.accessFurtherStudyEN, 'professionalStatusUA': app.professionalStatusUA, 'professionalStatusEN': app.professionalStatusEN,}))
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