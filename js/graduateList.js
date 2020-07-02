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
        updateAllEntries: function () {
            var refs = this.$refs;
            Object.keys(this.$refs).forEach(function (value) {
                if (value.startsWith("graduate")) {
                    var request = new HttpRequest();
                    var id = value.replace(/graduate/, '');
                    console.log(value);
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
                        }
                    };
                    request.sendPUTRequest("/euro_new/graduates", json);
                }
            });
        },
        tableHeaderFixed: function (ev) {
            var el = ev.target;
            var refs = this.$refs;
            var i = Math.ceil(el.scrollTop / 100);
            var li = 0;
            var h = 0;
            // console.log(ev);
            if (el.scrollTop > 0) {
                this.$refs.header.style.transform = 'translateY(' + el.scrollTop + 'px)'
            } else {
                this.$refs.header.style.transform = 'translateY(0px)'
            }
            if (el.scrollLeft > 0) {
                Object.keys(this.$refs).forEach(function (value) {
                    if (value.startsWith("graduate")) {
                        // if (li > i) {
                            // console.log(refs);
                        // console.log(h);
                        // console.log(el.scrollTop);
                            if (el.scrollTop <= h) {
                                refs[value][0].children[0].style.transform = 'translateX(' + el.scrollLeft + 'px)';
                                refs[value][0].children[0].style['background-color'] = '#c7c7bd';
                                // console.log(refs[value]);
                            } else {
                                refs[value][0].children[0].style.transform = '';
                                // refs[value][0].children[0].style['background-color'] = '#f9f9f9';
                                h += refs[value][0].scrollHeight;
                            }
                            // refs["header"][0].style['z-index'] = "1";
                            // refs[value][0].children[0].style.position = "relative";
                            // refs[value][0].children[0].style.position = "-";
                        }
                    // } else li++;
                });
            } else {
                Object.keys(this.$refs).forEach(function (value) {
                    if (value.startsWith("graduate")) {
                        refs[value][0].children[0].style.transform = '';
                        refs[value][0].children[0].style['background-color'] = '#f9f9f9';
                    }
                });
            }
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

var app = new Vue({
    el: '#app',
    data: {
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
                    console.log(request.xmlHttpRequestInstance.responseText);
                    var graduatesJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    console.log(graduatesJSON);
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
                    app.gridDataAll = graduatesJSON;
                    app.setUpPagination();
                    console.log(app.$refs);
                }
            };
            console.log(JSON.stringify({'qualificationId': this.qualificationId}));
            request.sendGETRequest("/euro_new/graduates?qualificationId=" + this.qualificationId, "");
        },
        setUpPagination: function () {
            app.pages = Math.ceil(app.gridDataAll.length / app.countEntriesEachPage);
            app.setPage(1);
            app.gridData = app.gridDataAll.slice((app.currentPage - 1) * app.countEntriesEachPage, ((app.currentPage - 1) * app.countEntriesEachPage) + app.countEntriesEachPage);
        },
        setPage: function(page) {
            if (page !== '..') { //Case when we don't need to change page because it is only decoration.
                if (page !== undefined)
                    app.currentPage = page;
                if (app.pages > 4) {
                    if (app.currentPage === app.pages) {
                        app.pagesArray = [];
                        app.pagesArray.push(1, '..', app.currentPage - 1, app.currentPage);
                    } else if (app.currentPage === 1) {
                        app.pagesArray = [];
                        app.pagesArray.push(1, 2, '..', app.pages);
                    } else if (app.currentPage >= app.pages - 2) {
                        app.pagesArray = [];
                        if (app.currentPage === app.pages - 2)
                            app.pagesArray.push(1, '..', app.currentPage - 1, app.currentPage, app.currentPage + 1, app.pages);
                        else
                            app.pagesArray.push(1, '..', app.currentPage - 1, app.currentPage, app.currentPage + 1);
                    } else {
                        app.pagesArray = [];
                        if (app.currentPage > 3)
                            app.pagesArray.push(1, '..', app.currentPage - 1, app.currentPage, app.currentPage + 1, '..', app.pages);
                        else if (app.currentPage === 3)
                            app.pagesArray.push(1, app.currentPage - 1, app.currentPage, app.currentPage + 1, '..', app.pages);
                        else
                            app.pagesArray.push(app.currentPage - 1, app.currentPage, app.currentPage + 1, '..', app.pages);
                    }
                } else {
                    app.pagesArray = [];
                    for (var i = 1; i < app.pages + 1; i++)
                        app.pagesArray.push(i);
                }
                app.gridData = app.gridDataAll.slice((app.currentPage - 1) * app.countEntriesEachPage, ((app.currentPage - 1) * app.countEntriesEachPage) + app.countEntriesEachPage);
            }
        }
    }
});