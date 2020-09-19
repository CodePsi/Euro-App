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
            sortOrders: sortOrders,
            teachingOptions: ['1 - Залік/Экзамен', '2 - Практики/Practices', '3 - Курсові роботи/Coursework', '4 - Атестації/Certification']
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
            var i = Math.ceil(el.scrollTop / 100);
            var li = 0;
            var h = 0;
            // console.log(ev);
            // console.log(this.$refs.header.children[0].children);
            if (el.scrollTop > 0) {

                Object.keys(this.$refs.header.children[0].children).forEach(function (value) {

                    refs.header.children[0].children[value].style.top = el.scrollTop + 'px';
                    refs.header.children[0].children[value].style.position = 'relative';
                    refs.header.children[0].children[value].style['z-index'] = '1';

                });
                // }
            } else {
                Object.keys(this.$refs.header.children[0].children).forEach(function (value) {
                    refs.header.children[0].children[value].style.top = '';
                    refs.header.children[0].children[value].style.position = '';
                    refs.header.children[0].children[value].style['z-index'] = '';
                });
            }
            if (el.scrollLeft > 0) {
                Object.keys(this.$refs).forEach(function (value) {
                    if (value.startsWith("graduate")) {

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
                        if (value.startsWith("graduate")) {
                            refs[value][0].children[0].style.left = '';
                            refs[value][0].children[0].style.position = '';
                            refs[value][0].children[0].style['z-index'] = '';
                            refs[value][0].children[0].style['background-color'] = '#f9f9f9';
                        }
                    }
                });

            }
        },
        displayDeleteDisciplineModalWindow: function (id) {
            app.activeModalValue = id;
            app.showDeleteEntryModal = true;
        }
    }
});
Vue.directive('tooltip', VTooltip.VTooltip)
Vue.directive('close-popover', VTooltip.VClosePopover)
Vue.component('v-popover', VTooltip.VPopover)
var app = new Vue({
    el: '#app',
    data: {
        activeModalValue: -1,
        showDeleteEntryModal: false,
        showInfoEntryModal: false,
        showInfoAboutTableEntryModal: false,
        searchQuery: '',
        gridColumns: ['назва дисципліни', 'Course title in English', 'кредити', 'години', 'навчання', 'диференціал'],
        gridData: [],
        gridDataAll: [],
        qualificationId: -1,
        currentPage: 1,
        pages: 1,
        pagesArray: [],
        countEntriesEachPage: 10,
        totalHours: 0,
        totalLoans: 0,
        amountOfDisciplines: 0,
        percentOfFullness: 0

},
    created: function() {
        var pathname = window.location.pathname;
        this.qualificationId = pathname.match(/\d+/)[0]; //Getting ID from URL (particularly from URI in this case)
        console.log(this.qualificationId);
        this.setUpAllDisciplines();

    },
    methods: {
        setUpAllDisciplines: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    // console.log(request.xmlHttpRequestInstance.responseText);
                    var disciplinesJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    // console.log(graduatesJSON);
                    app.amountOfDisciplines = disciplinesJSON.length;
                    for (var i = 0; i < disciplinesJSON.length; i++) {
                        app.totalLoans += parseInt(disciplinesJSON[i][4]);
                        app.totalHours += parseInt(disciplinesJSON[i][5]);
                        disciplinesJSON[i] = {
                            'id': disciplinesJSON[i][0],
                            // 'qualificationId': graduatesJSON[i][0],
                            'назва дисципліни': disciplinesJSON[i][2],
                            'Course title in English': disciplinesJSON[i][3],
                            'кредити': disciplinesJSON[i][4],
                            'години': disciplinesJSON[i][5],
                            'навчання': app.convertDifferential(1, disciplinesJSON[i][6]),
                            'диференціал': disciplinesJSON[i][7]
                        };
                    }
                    console.log(disciplinesJSON);
                    app.percentOfFullness = Math.round(app.calculatePercentOfFullness(disciplinesJSON) * 100);
                    app.qualifications = disciplinesJSON;
                    app.gridData = disciplinesJSON;
                    console.log(app.$refs);
                }
            };
            console.log(JSON.stringify({'qualificationId': this.qualificationId}));
            request.sendGETRequest("/euro_new/disciplines?qualificationId=" + this.qualificationId, "");
        },
        addNewDiscipline: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function () {
                if (request.isRequestSuccessful()) {
                    app.setUpAllDisciplines();
                    console.log(request.xmlHttpRequestInstance.responseText);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Новий запис додано',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            };

            request.sendPOSTRequest("/euro_new/disciplines?qualificationId=" + this.qualificationId, "")
        },
        deleteDiscipline: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function () {
                if (request.isRequestSuccessful()) {
                    app.setUpAllDisciplines();
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

            request.sendDELETERequest("/euro_new/disciplines?id=" + this.activeModalValue, "")
        },
        updateAllDisciplines: function () {
            var refs = this.$children[1].$refs; //Accessing to grid-template's refs via children component in parent component
            console.log(refs);
            Object.keys(refs).forEach(function (value) {
                if (value.startsWith("discipline")) {
                    var request = new HttpRequest();
                    var id = value.replace(/discipline/, '');
                    var children = refs[value][0].children;
                    var options = children[4].children[0].options;
                    var differentialOptions = children[5].children[0].options;

                    var json = JSON.stringify({
                        'id': id,
                        'courseTitleUA': children[0].innerText,
                        'courseTitleEN': children[1].innerText,
                        'loans': children[2].innerText,
                        'hours': children[3].innerText,
                        'teaching': app.convertDifferential(2, options[options.selectedIndex]),
                        'differential': differentialOptions[differentialOptions.selectedIndex].innerText
                    });
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
                    request.sendPUTRequest("/euro_new/disciplines", json);
                }
                console.log(json);
            });
        },
        convertDifferential: function (mode, value) {
            if (mode === 1) { //Convert numbers to string representation
                var values = [' - Залік/Экзамен', ' - Практики/Practices', ' - Курсові роботи/Coursework', ' - Атестації/Certification'];
                return value + values[parseInt(value) - 1];
            } else { //Otherwise vice verse
                return value.innerText.charAt(0);
            }
        },
        calculatePercentOfFullness: function (data) {
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
        }
    }
});