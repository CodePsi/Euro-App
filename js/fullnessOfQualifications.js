var loader = Vue.component('loader', {
    template: '#loader'
});
var componentGrid = Vue.component('grid', {
    template: '#grid-template',
    props: {
        heroes: Array,
        columns: Array,
        filterKey: String
    },
    data: function () {
        var sortOrders = {};
        this.columns.forEach(function (key) {
            sortOrders[key] = 1
        });
        sortOrders['порядковий номер'] = -1;
        return {
            sortKey: 'порядковий номер',
            sortOrders: sortOrders,
            currentPage: 1,
            pages: 1,
            pagesArray: [],
            countEntriesEachPage: 10
        }
    },
    created: function() {
    },
    computed: {
        filteredHeroes: function () {
            var sortKey = this.sortKey;
            var filterKey = this.filterKey && this.filterKey.toLowerCase();
            var order = this.sortOrders[sortKey] || 1;
            var heroes = this.heroes;
            if (filterKey) {
                heroes = heroes.filter(function (row) {
                    return Object.keys(row).some(function (key) {
                        return String(row[key]).toLowerCase().indexOf(filterKey) > -1;
                    })
                })
            }
            if (sortKey) {
                heroes = heroes.slice().sort(function (a, b) {
                    a = a[sortKey];
                    b = b[sortKey];
                    return (a === b ? 0 : a > b ? 1 : -1) * order;
                })
            }
            return heroes
        }
    },
    filters: {
        capitalize: function (str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    },
    methods: {
        sortBy: function (key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
        },
        editQualificationEntry: function (id) {
            window.location = "/euro_new/control-page/group/edit/"+id+"/qualification";
        },
        displayDeleteModalWindow: function (id) {
            app.showDeleteEntryModal = true;
            app.activeModalValue = id;
        }
    }
});

var app = new Vue({
    el: '#app',
    data: function(){
        return {
            gridColumns: ['порядковий номер', 'кваліфікація', 'зміст та результати', 'дисципліни', 'студенти', 'оцінки'],
            gridData: [],
            searchQuery: '',
            gridDataAll: [],
            qualifications: [],
            contentsAndResults: [],
            disciplines: [],
            estimates: [],
            graduates: [],
            nationalFrameworks: [],
            showLoader: true
        }
    },
    methods: {
        init: function() {
                this.getAllQualifications(this.gridData);
            // this.gridData.push({'порядковий номер': 3})
            // this.gridData[0]['кваліфікація'] = 1;
        },
        getAllQualifications: function (gridData) {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    var qualificationsJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    console.log(qualificationsJSON);
                    for (var i = 0; i < qualificationsJSON.length; i++) {
                        qualificationsJSON[i] = {
                            'id': parseInt(qualificationsJSON[i][0]),
                            'qualificationEN': qualificationsJSON[i][1],
                            'qualificationUA': qualificationsJSON[i][2],
                            'mainFieldStudyUA': qualificationsJSON[i][3],
                            'mainFieldStudyEN': qualificationsJSON[i][4],
                            'degree': qualificationsJSON[i][5],
                            'date': qualificationsJSON[i][6],
                            'userId': qualificationsJSON[i][7],
                            'abbreviation': qualificationsJSON[i][8],
                            'fieldStudyUA': qualificationsJSON[i][9],
                            'fieldStudyEN': qualificationsJSON[i][10],
                            'firstSpecialtyUA': qualificationsJSON[i][11],
                            'firstSpecialtyEN': qualificationsJSON[i][12],
                            'secondSpecialtyUA': qualificationsJSON[i][13],
                            'secondSpecialtyEN': qualificationsJSON[i][14],
                            'specializationUA': qualificationsJSON[i][15],
                            'specializationEN': qualificationsJSON[i][16],
                            'educationalProgramUA': qualificationsJSON[i][17],
                            'educationalProgramEN': qualificationsJSON[i][18]
                        };
                    }
                    app.qualifications = qualificationsJSON;
                    for (let i = 0; i < app.qualifications.length; i++) {
                        app.getContentsAndResults(app.qualifications[i].id, i, gridData);
                        app.getAllDisciplines(app.qualifications[i].id, i, gridData);
                        app.getAllGraduates(app.qualifications[i].id, i, gridData);
                        gridData.push({
                            'порядковий номер': app.qualifications[i]['id'],
                            'кваліфікація': app.calculatePercentOfFullnessForQualifications(app.qualifications[i]),
                        });
                    }

                    app.showLoader = false;
                }
            };
            request.sendGETRequest("/euro_new/qualifications/", "");
        },
        getContentsAndResults: function (qualificationId, index, gridData) {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    app.contentsAndResults = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    Vue.set(gridData[index], ['зміст та результати'], app.calculatePercentOfFullnessForContentsAndResults(app.contentsAndResults))
                }
            };
            request.sendGETRequest("/euro_new/contentsAndResults/" + qualificationId, "");
            return request;
        },
        getAllDisciplines: function (qualificationId, index, gridData) {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    // console.log(request.xmlHttpRequestInstance.responseText);
                    var disciplinesJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    // console.log(graduatesJSON);
                    for (var i = 0; i < disciplinesJSON.length; i++) {
                        disciplinesJSON[i] = {
                            'id': disciplinesJSON[i][0],
                            'nameOfDiscipline': disciplinesJSON[i][2],
                            'courseTitleEN': disciplinesJSON[i][3],
                            'loans': disciplinesJSON[i][4],
                            'hours': disciplinesJSON[i][5],
                            'teaching': disciplinesJSON[i][6],
                            'differential': disciplinesJSON[i][7]
                        };
                    }
                    app.disciplines = disciplinesJSON;
                    var num = app.calculatePercentOfFullnessForDisciplines(app.disciplines);
                    if (isNaN(num))
                        num = "Відсутні дисципліни"
                    Vue.set(gridData[index], ['дисципліни'], num)

                }
            };
            request.sendGETRequest("/euro_new/disciplines?qualificationId=" + qualificationId, "");
        },
        getAllGraduates: function (qualificationId, index, gridData) {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    var graduatesJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    // app.percentOfFullness = Math.round(app.calculatePercentOfFullness(graduatesJSON) * 100);
                    // for (var i = 0; i < graduatesJSON.length; i++) {
                    //     graduatesJSON[i] = {
                    //         'id': graduatesJSON[i][1],
                    //         // 'qualificationId': graduatesJSON[i][0],
                    //         'lastnameUA': graduatesJSON[i][2],
                    //         'lastnameEN': graduatesJSON[i][3],
                    //         'firstNameUA': graduatesJSON[i][4],
                    //         'firstNameEN': graduatesJSON[i][5],
                    //         'date': graduatesJSON[i][6],
                    //         'serialDiploma': graduatesJSON[i][7],
                    //         'numberDiploma': graduatesJSON[i][8],
                    //         'numberAddition': graduatesJSON[i][9],
                    //         'prevDocumentUA': graduatesJSON[i][10],
                    //         'prevDocumentEN': graduatesJSON[i][11],
                    //         'prevSerialNumberAddition': graduatesJSON[i][12],
                    //         'durationOfTrainingUA': graduatesJSON[i][13],
                    //         'durationOfTrainingEN': graduatesJSON[i][14],
                    //         'trainingStart': graduatesJSON[i][15],
                    //         'trainingEnd': graduatesJSON[i][16],
                    //         // 'actualNumberOfEstimates': graduatesJSON[i][17],
                    //         'decisionDate': graduatesJSON[i][18],
                    //         'protocolNumber': graduatesJSON[i][19],
                    //         'qualificationAwardedUA': graduatesJSON[i][20],
                    //         'qualificationAwardedEN': graduatesJSON[i][21],
                    //         'issuedBy': graduatesJSON[i][22],
                    //         'issuedByEN': graduatesJSON[i][23]
                    //     };
                    // }

                    app.graduates = graduatesJSON;
                    app.getAllEstimates(app.graduates, gridData, index);

                    var num = app.calculatePercentOfFullnessForDisciplines(app.disciplines);
                    if (isNaN(num))
                        num = "Відсутні студенти"
                    Vue.set(gridData[index], ['студенти'], num)

                }
            };
            request.sendGETRequest("/euro_new/graduates?qualificationId=" + qualificationId, "");
        },
        getNationalFramework: function (qualificationId, index, gridData) {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    app.nationalFrameworks = JSON.parse(request.xmlHttpRequestInstance.responseText);

                    Vue.set(gridData[index], ['студенти'], app.calculatePercentOfFullnessForNationalFrameworks(app.nationalFrameworks))
                }
            };
            request.sendGETRequest("/euro_new/nationalFrameworks/" + qualificationId, "");
        },
        getAllEstimates: function (graduates, gridData, index) {
            for (var i = 0; i < graduates.length; i++) {
                const request = new HttpRequest();
                (function (i) {
                    request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                        if (request.isRequestSuccessful()) {
                            var json = JSON.parse(request.xmlHttpRequestInstance.responseText);

                            // app.gridData.push(gridDataJson);
                            // app.gridData = app.gridData.sort(function (a, b) {
                            //     a = a['студент'];
                            //     b = b['студент'];
                            //     return (a === b ? 0 : a > b ? 1 : -1)
                            // });
                            app.estimates.push(json);
                            console.log(json.length === 0);
                            if (json.length === 0) {
                                console.log('something');
                                Vue.set(gridData[index], ['оцінки'], 0)
                            } else {
                                var num = app.calculatePercentOfFullnessForEstimates(app.estimates);
                                console.log(num)
                                Vue.set(gridData[index], ['оцінки'], num)
                                app.estimates = [];
                            }
                        }
                    };
                })(i);

                request.sendGETRequest("/euro_new/estimates?graduateId=" + graduates[i][0], "");
            }
        },
        calculatePercentOfFullnessForContentsAndResults: function (data) {
            var countOfEmptyFields = 0;
            Object.keys(data).forEach(function (value) {
                if (data[value] === '') {
                    countOfEmptyFields++;
                }
            });
            var length = Object.keys(data).length;

            return (length - countOfEmptyFields) / length;
        },
        convertDifferential: function (mode, value) {
            if (mode === 1) { //Convert numbers to string representation
                var values = [' - Залік/Экзамен', ' - Практики/Practices', ' - Курсові роботи/Coursework', ' - Атестації/Certification'];
                return value + values[parseInt(value) - 1];
            } else { //Otherwise vice verse
                return value.innerText.charAt(0);
            }
        },
        calculatePercentOfFullnessForDisciplines: function (data) {
            var countOfEmptyFields = 0;
            for (var i = 0; i < data.length; i++) {
                for (var j = 0; j < data[i].length; j++) {
                    if (data[i][j] === "") {
                        countOfEmptyFields++;
                        break;
                    }
                }
            }
            var length = data.length;

            return (length - countOfEmptyFields) / length;
        },
        calculatePercentOfFullnessForQualifications: function (data) {
            var countOfEmptyFields = 0;
            Object.keys(data).forEach(function (value) {
                if (data[value] === '') {
                    countOfEmptyFields++;
                }
            });
            var length = Object.keys(data).length;

            return (length - countOfEmptyFields) / length;
        },
        convertToECTS: function (mark) {
            switch (true) {
                case mark >= -1 && mark < 50:
                    return 'F';
                case mark >= 50 && mark <= 60:
                    return 'E';
                case mark >= 61 && mark <= 70:
                    return 'D';
                case mark >= 71 && mark <= 80:
                    return 'C';
                case mark >= 81 && mark < 90:
                    return 'B';
                case mark >= 90:
                    return 'A';
            }
        },
        getNationalGrade: function (mark, differential) {
            if (differential === 'Оцінка') {
                switch (true) {
                    case mark >= -1 && mark < 50:
                        return 'Не зараховано/Fail';
                    case mark >= 50 && mark <= 60:
                        return 'Задовільно/Satisfactory';
                    case mark >= 61 && mark <= 70:
                        return 'Задовільно/Satisfactory';
                    case mark >= 71 && mark <= 80:
                        return 'Добре/Good';
                    case mark >= 81 && mark < 90:
                        return 'Добре/Good';
                    case mark >= 90:
                        return 'Відмінно/Excellent';
                }
            } else {
                if (mark < 50) {
                    return 'Не зараховано/Fail';
                } else {
                    return 'Зараховано/Passed';
                }
            }
        },
        calculatePercentOfFullnessForEstimates: function (data) {
            var countOfEmptyFields = 0;
            for (var i = 0; i < data.length; i++) {
                Object.keys(data[i]).some(function (value) {
                    // console.log(data[i][value]['mark']);
                    if (data[i][value]['mark'] <= 0) {
                        // console.log('ts')
                        countOfEmptyFields++;
                    }
                    return data[i][value]['mark'] < 0;
                });
            }
            var length = data.length;
            // console.log(length)
            // console.log(countOfEmptyFields)
            return (length - countOfEmptyFields) / length;
        },
        calculatePercentOfFullnessForGraduates: function (data) {
            var countOfEmptyFields = 0;
            for (var i = 0; i < data.length; i++) {
                for (var j = 0; j < data[i].length; j++) {
                    if (data[i][j] === "") {
                        countOfEmptyFields++;
                        break;
                    }
                }
            }
            var length = data.length;

            return (length - countOfEmptyFields) / length;
        },
        calculatePercentOfFullnessForNationalFrameworks: function (data) {
            var countOfEmptyFields = 0;
            Object.keys(data).forEach(function (value) {
                if (data[value] === '') {
                    countOfEmptyFields++;
                }
            });
            var length = Object.keys(data).length;

            return (length - countOfEmptyFields) / length;
        }
    },
    mounted(){
        this.init();

        // console.log(this.qualifications);
        // for (var i = 0; i < this.qualifications.length; i++) {
        //     this.gridColumns.push({'порядковий номер':this.qualifications[i].id, 'кваліфікація': this.calculatePercentOfFullnessForQualifications(this.qualifications[i])});
        // }
        // if (this.qualifications.length <= 0) app.$mount();
    }
});