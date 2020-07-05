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
            var i = Math.ceil(el.scrollTop / 100);
            var li = 0;
            var h = 0;
            // console.log(ev);
            // console.log(this.$refs.header.children[0].children);
            if (el.scrollTop > 0) {
                // this.$refs.header.style.transform = 'translateY(' + el.scrollTop + 'px)'
                // this.$refs.header.style.top = el.scrollTop + 'px';
                // this.$refs.header.style.position = 'relative'
                Object.keys(this.$refs.header.children[0].children).forEach(function (value) {
                    // console.log(refs.header.children[0].children[value]);
                    // } else {
                    // this.$refs.header.style.transform = 'translateY(0px)'
                    refs.header.children[0].children[value].style.top = el.scrollTop + 'px';
                    refs.header.children[0].children[value].style.position = 'relative';
                    refs.header.children[0].children[value].style['z-index'] = '1';
                    // this.$refs.header.style.top = '0px'
                    // this.$refs.header.style.position = 'relative'
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
                        // if (li > i) {
                            // console.log(refs);
                        // console.log(h);
                        // console.log(el.scrollTop);
                        //     if (el.scrollTop <= h) {
                                // refs[value][0].children[0].style.transform = 'translateX(' + el.scrollLeft + 'px)';
                        if (refs[value][0] !== undefined) {
                            refs[value][0].children[0].style.left = el.scrollLeft + 'px';
                            refs[value][0].children[0].style.position = 'relative';
                            refs[value][0].children[0].style['z-index'] = 'auto';
                            refs[value][0].children[0].style['background-color'] = '#c7c7bd';
                        }
                                // console.log(refs[value]);
                            // } else {
                                // refs[value][0].children[0].style.transform = '';
                                // refs[value][0].children[0].style.left = 0;

                                // refs[value][0].children[0].style['background-color'] = '#f9f9f9';
                                // h += refs[value][0].scrollHeight;
                            // }
                            // refs["header"][0].style['z-index'] = "1";
                            // refs[value][0].children[0].style.position = "relative";
                            // refs[value][0].children[0].style.position = "-";
                        }
                    // } else li++;
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
        displayDeleteGraduateModalWindow: function (id) {
            app.activeModalValue = id;
            app.showDeleteEntryModal = true;
        }
    }
});
// $(document).ready(function() {
//     $('tbody').scroll(function(e) { //detect a scroll event on the tbody
//         /*
//       Setting the thead left value to the negative valule of tbody.scrollLeft will make it track the movement
//       of the tbody element. Setting an elements left value to that of the tbody.scrollLeft left makes it maintain 			it's relative position at the left of the table.
//       */
//         $('thead').css("left", -$("tbody").scrollLeft()); //fix the thead relative to the body scrolling
//         $('thead th:nth-child(1)').css("left", $("tbody").scrollLeft()); //fix the first cell of the header
//         $('tbody td:nth-child(1)').css("left", $("tbody").scrollLeft()); //fix the first column of tdbody
//     });
// });
// Vue.use(VTooltip);
Vue.directive('tooltip', VTooltip.VTooltip)
Vue.directive('close-popover', VTooltip.VClosePopover)
Vue.component('v-popover', VTooltip.VPopover)
var app = new Vue({
    el: '#app',
    data: {
        activeModalValue: -1,
        showDeleteEntryModal: false,
        searchQuery: '',
        gridColumns: ['прізвище', 'family name(s)', 'ім\'я та по-батькові', 'given name(s)', 'дата народження', 'серія диплома',
            'номер диплома', 'номер додатка', 'попередній документ про освіту', 'the previous document of education',
            'серія та номер попереднього документу про освіту', 'тривалість навчання', 'duration of training', 'початок навчання',
            'кінець навчання', 'рішенням екзаменаційної комісії від', 'протокол №', 'присвоєно кваліфікацію', 'qualification of',
            'ким виданий попередній документ про освіту; дата видачі', 'previous education document; date of issue'],
        gridData: [],
        gridDataAll: [],
        qualificationId: -1,
        currentPage: 1,
        pages: 1,
        pagesArray: [],
        countEntriesEachPage: 10
    },
    created: function() {
        var pathname = window.location.pathname;
        this.qualificationId = pathname.match(/\d/)[0];
        console.log(this.qualificationId);
        this.updateAllGraduates();

    },
    methods: {
        updateAllGraduates: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    // console.log(request.xmlHttpRequestInstance.responseText);
                    var graduatesJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    // console.log(graduatesJSON);
                    for (var i = 0; i < graduatesJSON.length; i++) {
                        graduatesJSON[i] = {
                            'id': graduatesJSON[i][1],
                            // 'qualificationId': graduatesJSON[i][0],
                            'прізвище': graduatesJSON[i][2],
                            'family name(s)': graduatesJSON[i][3],
                            'ім\'я та по-батькові': graduatesJSON[i][4],
                            'given name(s)': graduatesJSON[i][5],
                            'дата народження': graduatesJSON[i][6],
                            'серія диплома': graduatesJSON[i][7],
                            'номер диплома': graduatesJSON[i][8],
                            'номер додатка': graduatesJSON[i][9],
                            'попередній документ про освіту': graduatesJSON[i][10],
                            'the previous document of education': graduatesJSON[i][11],
                            'серія та номер попереднього документу про освіту': graduatesJSON[i][12],
                            'тривалість навчання': graduatesJSON[i][13],
                            'duration of training': graduatesJSON[i][14],
                            'початок навчання': graduatesJSON[i][15],
                            'кінець навчання': graduatesJSON[i][16],
                            'actualNumberOfEstimates': graduatesJSON[i][17],
                            'рішенням екзаменаційної комісії від': graduatesJSON[i][18],
                            'протокол №': graduatesJSON[i][19],
                            'присвоєно кваліфікацію': graduatesJSON[i][20],
                            'qualification of': graduatesJSON[i][21],
                            'ким виданий попередній документ про освіту; дата видачі': graduatesJSON[i][22],
                            'previous education document; date of issue': graduatesJSON[i][23]
                        };
                    }
                    app.qualifications = graduatesJSON;
                    console.log(graduatesJSON);
                    app.gridData = graduatesJSON;
                    console.log(app.$refs);
                }
            };
            console.log(JSON.stringify({'qualificationId': this.qualificationId}));
            request.sendGETRequest("/euro_new/graduates?qualificationId=" + this.qualificationId, "");
        },
        addNewGraduate: function () {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function () {
                if (request.isRequestSuccessful()) {
                    app.updateAllGraduates();
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

            request.sendPOSTRequest("/euro_new/graduates?qualificationId=" + this.qualificationId, "")
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
            var refs = this.$children[0].$refs; //Accessing to grid-template's refs via children component in parent component
            Object.keys(refs).forEach(function (value) {
                if (value.startsWith("graduate")) {
                    var request = new HttpRequest();
                    var id = value.replace(/graduate/, '');
                    // console.log(value);
                    var children = refs[value][0].children;
                    var json = JSON.stringify({
                        'id': id,
                        // 'qualificationId': value,
                        'lastNameUA': children[0].innerText,
                        'lastNameEN': children[1].innerText,
                        'firstNameUA': children[2].innerText,
                        'firstNameEN': children[3].innerText,
                        'birthday': children[4].innerText,
                        'serialDiploma': children[5].innerText,
                        'numberOfDiploma': children[6].innerText,
                        'numberAddition': children[7].innerText,
                        'prevDocumentUA': children[8].innerText,
                        'prevDocumentEN': children[9].innerText,
                        'prevSerialNumberAddition': children[10].innerText,
                        'durationOfTrainingUA': children[11].innerText,
                        'durationOfTrainingEN': children[12].innerText,
                        'trainingStart': children[13].innerText,
                        'trainingEnd': children[14].innerText,
                        // 'actualNumberOfEstimates': children[15].innerText,
                        'decisionDate': children[15].innerText,
                        'protocolNum': children[16].innerText,
                        'qualificationAwardedUA': children[17].innerText,
                        'qualificationAwardedEN': children[18].innerText,
                        'issuedBy': children[19].innerText,
                        'issuedByEN': children[20].innerText
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
                    request.sendPUTRequest("/euro_new/graduates", json);
                }
            });
        }
    }
});