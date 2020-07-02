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
        editQualificationEntry: function (id) {
            window.location += "group/edit/" + id + "/qualification";
        }
    }
});
var app = new Vue({
    el: '#app',
    data: {

        qualifications: [],
        searchQuery: '',
        gridColumns: ['id', 'date', 'abbreviation', 'qualificationUA'],
        gridData: [],
        gridDataAll: [],
        currentPage: 1,
        pages: 1,
        pagesArray: [],
        countEntriesEachPage: 10
    },
    created: function() {
        this.updateAllQualifications();
    },
    methods: {
        updateAllQualifications: function () {
                var request = new HttpRequest();
                request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                    if (request.isRequestSuccessful()) {
                        var qualificationsJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                        console.log(qualificationsJSON);
                        for (var i = 0; i < qualificationsJSON.length; i++) {
                            qualificationsJSON[i] = {
                                'id': qualificationsJSON[i][0],
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
                        app.gridDataAll = qualificationsJSON;
                        // console.log(app.gridDataAll);
                        app.setUpPagination();
                    }
                };
                request.sendGETRequest("/euro_new/qualifications/", "");
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