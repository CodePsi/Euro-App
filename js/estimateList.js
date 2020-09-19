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
        return {
            sortKey: '',
            sortOrders: sortOrders
        }
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
        tableHeaderFixed: function (ev) {
            var el = ev.target;
            var refs = this.$refs;
            if (el.scrollTop > 0) {
                Object.keys(this.$refs.header.children[0].children).forEach(function (value) {
                    refs.header.children[0].children[value].style.top = el.scrollTop + 'px';
                    refs.header.children[0].children[value].style.position = 'relative';
                    refs.header.children[0].children[value].style['z-index'] = '1';
                });
            } else {
                Object.keys(this.$refs.header.children[0].children).forEach(function (value) {
                    refs.header.children[0].children[value].style.top = '';
                    refs.header.children[0].children[value].style.position = '';
                    refs.header.children[0].children[value].style['z-index'] = '';
                });
            }
            if (el.scrollLeft > 0) {
                Object.keys(this.$refs).forEach(function (value) {
                    if (!value.startsWith("estimate")) {
                        if (refs[value][0] !== undefined) {
                            refs[value][0].children[0].style.left = el.scrollLeft + 'px';
                            refs[value][0].children[0].style.position = 'relative';
                            refs[value][0].children[0].style['z-index'] = 'auto';
                            refs[value][0].children[0].style['background-color'] = '#c7c7bd';
                        }
                    }
                });
            } else {
                Object.keys(this.$refs).forEach(function (value) {
                    if (refs[value][0] !== undefined) {
                        if (!value.startsWith("estimate")) {
                            refs[value][0].children[0].style.left = '';
                            refs[value][0].children[0].style.position = '';
                            refs[value][0].children[0].style['z-index'] = '';
                            refs[value][0].children[0].style['background-color'] = '#f9f9f9';
                        }
                    }
                });

            }
        },
        getValue: function (v) {
            console.log(v["mark"]);
            return "123";
        }
    }
});
Vue.directive('tooltip', VTooltip.VTooltip)
Vue.directive('close-popover', VTooltip.VClosePopover)
Vue.component('v-popover', VTooltip.VPopover)
var app = new Vue({
    el: '#app',
    data: function(){
        return {
            activeModalValue: -1,
            showDeleteEntryModal: false,
            showInfoEntryModal: false,
            searchQuery: '',
            gridColumns: ['студент'],
            gridData: [],
            gridDataAll: [],
            qualificationId: -1,
            currentPage: 1,
            pages: 1,
            pagesArray: [],
            countEntriesEachPage: 10,
            disciplines:  [],
            percentOfFullness: 0
        }
    },
    created: function() {
        var pathname = window.location.pathname;
        this.qualificationId = pathname.match(/\d+/)[0]; //Getting ID from URL (particularly from URI in this case)
        // this.dddas.push(1);
        this.setUpAllGraduates();
        this.setUpAllDisciplines();
    },
    methods: {
        setUpAllEstimates: function () {
            var graduates = this.graduates;
            var disciplines = this.disciplines;
            for (var i = 0; i < this.graduates.length; i++) {
                console.log();
                const request = new HttpRequest();
                (function (i) {
                    request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                        if (request.isRequestSuccessful()) {
                            var json = JSON.parse(request.xmlHttpRequestInstance.responseText);
                            console.log(json);
                            var gridDataJson = {'id': graduates[i]['id'], 'студент': graduates[i]['прізвище']};
                            for (var j = 0; j < json.length; j++) {
                                var discipline = disciplines.filter(function (value) {
                                    return value.id === json[j][1];
                                });
                                var mark = json[j][2] !== '' ? parseInt(json[j][2]) : -1;
                                var ects = app.convertToECTS(mark);
                                if (discipline[0] !== undefined) {
                                    var national = app.getNationalGrade(mark, discipline[0].differential);
                                    console.log(discipline[0].nameOfDiscipline);
                                    gridDataJson[discipline[0].nameOfDiscipline] = {
                                        'id': json[j][5],
                                        'mark': mark,
                                        'ECTS': ects,
                                        'national': national
                                    };
                                }
                            }
                            app.gridData.push(gridDataJson);
                                app.gridData = app.gridData.sort(function (a, b) {
                                    a = a['студент'];
                                    b = b['студент'];
                                    return (a === b ? 0 : a > b ? 1 : -1)
                                });
                            app.percentOfFullness = Math.round(app.calculatePercentOfFullness(app.gridData) * 100);
                        }
                    };
                })(i);

                request.sendGETRequest("/euro_new/estimates?graduateId=" + this.graduates[i].id, "");
            }

            console.log('done');

        },
        addNewGraduate: function () {
            // var request = new HttpRequest();
            // request.xmlHttpRequestInstance.onreadystatechange = function () {
            //     if (request.isRequestSuccessful()) {
            //         app.updateAllGraduates();
            //         console.log(request.xmlHttpRequestInstance.responseText);
            //         Swal.fire({
            //             position: 'top-end',
            //             icon: 'success',
            //             title: 'Новий запис додано',
            //             showConfirmButton: false,
            //             timer: 1500
            //         })
            //     }

            // };

            // request.sendPOSTRequest("/euro_new/graduates?qualificationId=" + this.qualificationId, "")
            console.log(this.disciplines)

        },
        deleteGraduate: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function () {
                if (request.isRequestSuccessful()) {
                    app.updateAllGraduates();
                    app.showDeleteEntryModal = false;
                    console.log(request.xmlHttpRequestInstance.responseText);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Запис успішно видалено',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            };

            request.sendDELETERequest("/euro_new/graduates?id=" + this.activeModalValue, "")
        },
        updateAllEntries: function () {
            var refs = this.$children[1].$refs; //Accessing to grid-template's refs via children component in parent component
            console.log(refs);
            var i = 0;
            Object.keys(refs).forEach(function (value) {
                if (value.startsWith("estimate")) {
                    var request = new HttpRequest();
                    var id = -1;
                    if (value.startsWith("estimate"))
                        id = value.replace(/estimate/, '');
                // else
                //         id = value.replace(/graduate/, '');
                    // console.log(value);
                    var children = refs[value][0].children;
                    // console.log(children.length);
                    // console.log(children);
                    // for (var i = 1; i < children.length; i++) {
                    //     console.log(i);
                    //     const marks = children[i].innerText.split('\n');
                        var json = JSON.stringify({
                            'id': id,
                            'estimateNum': children[0].innerText,
                            'estimateChar': children[1].innerText,
                            'estimateUA': children[2].innerText
                        });

                        console.log(json);
                        i++;
                        console.log(i);
                    // }
                    request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                        if (request.isRequestSuccessful()) {
                            console.log(request.xmlHttpRequestInstance.responseText);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Дані було збережено :)',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    };
                    request.sendPUTRequest("/euro_new/estimates", json);
                }
            });
        },
        setUpAllDisciplines: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    var disciplinesJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    for (var i = 0; i < disciplinesJSON.length; i++) {
                        app.gridColumns.push(disciplinesJSON[i][2]);
                        disciplinesJSON[i] = {
                            'id': disciplinesJSON[i][0],
                            'nameOfDiscipline': disciplinesJSON[i][2],
                            'courseTitleEN': disciplinesJSON[i][3],
                            'loans': disciplinesJSON[i][4],
                            'hours': disciplinesJSON[i][5],
                            'teaching': disciplinesJSON[i][6],
                            'differential': disciplinesJSON[i][7]
                        };
                        // console.log(app.gridColumns);

                    }
                    // console.log(app.gridColumns);
                    app.disciplines = disciplinesJSON;
                    app.setUpAllEstimates();
                    // console.log(dis.length);
                }
            };
            request.sendGETRequest("/euro_new/disciplines?qualificationId=" + this.qualificationId, "");
        },
        setUpAllGraduates: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    // console.log(request.xmlHttpRequestInstance.responseText);
                    var graduatesJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    // console.log(graduatesJSON);
                    for (var i = 0; i < graduatesJSON.length; i++) {
                        graduatesJSON[i] = {
                            'id': graduatesJSON[i][1],
                            'прізвище': graduatesJSON[i][2]

                        };
                    }
                    app.graduates = graduatesJSON;
                    // console.log(graduatesJSON);
                    // app.gridData = graduatesJSON;
                    // console.log(app.$refs);
                }
            };
            // console.log(JSON.stringify({'qualificationId': this.qualificationId}));
            request.sendGETRequest("/euro_new/graduates?qualificationId=" + this.qualificationId, "");
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
        calculatePercentOfFullness: function (data) {
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
        }
    }
});