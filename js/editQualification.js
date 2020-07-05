var app = new Vue({
    el: '#app',
    data: {
        abbreviation: '',
        degree: '',
        qualificationUA: '',
        qualificationEN: '',
        fieldOfStudyUA: '',
        fieldOfStudyEN: '',
        firstSpecialtyUA: '',
        firstSpecialtyEN: '',
        educationProgramUA: '',
        educationProgramEN: '',
        secondSpecialtyUA: '',
        secondSpecialtyEN: '',
        specializationUA: '',
        specializationEN: '',
        qualificationId: -1,
        qualificationData: []
    },
    created: function () {
        var pathname = window.location.pathname;
        this.qualificationId = pathname.match(/\d/)[0]; //Getting ID from URL (particularly from URI in this case)
        var request = new HttpRequest();
        request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
            if (request.isRequestSuccessful()) {
                var qualificationJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                app.abbreviation = qualificationJSON.abbreviation;
                app.degree = qualificationJSON.degree;
                app.qualificationUA = qualificationJSON.qualificationUA;
                app.qualificationEN = qualificationJSON.qualificationEN;
                app.firstSpecialtyUA = qualificationJSON.firstSpecialtyUA;
                app.firstSpecialtyEN = qualificationJSON.firstSpecialtyEN;
                app.fieldOfStudyUA = qualificationJSON.fieldOfStudyUA;
                app.fieldOfStudyEN = qualificationJSON.fieldOfStudyEN;
                app.educationProgramUA = qualificationJSON.educationProgramUA;
                app.educationProgramEN = qualificationJSON.educationProgramEN;
                app.secondSpecialtyUA = qualificationJSON.secondSpecialtyUA;
                app.secondSpecialtyEN = qualificationJSON.secondSpecialtyEN;
                app.specializationUA = qualificationJSON.specializationUA;
                app.specializationEN = qualificationJSON.specializationEN;
            }
        };
        request.sendGETRequest("/euro_new/qualifications/" + this.qualificationId, "");
    },
    methods: {
        updateAllQualifications: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    // console.log(qualificationJSON.qualificationEN);
                    app.qualificationData = JSON.parse(request.xmlHttpRequestInstance.responseText);
                }
            };
            request.sendGETRequest("/euro_new/qualifications/" + app.qualificationId, "");
        },
        updateQualification: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    console.log(request.xmlHttpRequestInstance.responseText);
                }
            };

            request.sendPUTRequest("/euro_new/qualifications/" + app.qualificationId, JSON.stringify({'abbreviation': app.abbreviation, 'degree': app.degree, 'qualificationUA': app.qualificationUA,
            'qualificationEN': app.qualificationEN, 'fieldOfStudyUA': app.fieldOfStudyUA, 'fieldOfStudyEN': app.fieldOfStudyEN, 'firstSpecialtyUA': app.firstSpecialtyUA, 'firstSpecialtyEN': app.firstSpecialtyEN, 'educationalProgramUA': app.educationProgramUA, 'educationalProgramEN': app.educationProgramEN,
            'secondSpecialtyUA': app.secondSpecialtyUA, 'secondSpecialtyEN': app.secondSpecialtyEN, 'specializationUA': app.specializationUA, 'specializationEN': app.specializationEN}))
        }
    }
});