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
    data: {

        qualifications: [],
        showDeleteEntryModal: false,
        activeModalValue: 0,
        searchQuery: '',
        gridColumns: ['порядковий номер', 'дата створення', 'назва групи', 'назва кваліфікації'],
        gridData: [],
        gridDataAll: [],
        username: '',
        isAdmin: false
    },
    mounted: function() {
        this.updateAllQualifications();
         this.getActiveUser();
    },
    methods: {
        updateAllQualifications: function () {
                var request = new HttpRequest();
                request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                    if (request.isRequestSuccessful()) {
                        var qualificationsJSON = JSON.parse(request.xmlHttpRequestInstance.responseText);
                        console.log(qualificationsJSON);
                        for (var i = 0; i < qualificationsJSON.length; i++) {
                            var date = qualificationsJSON[i][6];
                            // var separatedValues = date.split('.');
                            // var newDate = new Date(separatedValues[]);
                            qualificationsJSON[i] = {
                                'порядковий номер': parseInt(qualificationsJSON[i][0]),
                                'qualificationEN': qualificationsJSON[i][1],
                                'назва кваліфікації': qualificationsJSON[i][2],
                                'mainFieldStudyUA': qualificationsJSON[i][3],
                                'mainFieldStudyEN': qualificationsJSON[i][4],
                                'degree': qualificationsJSON[i][5],
                                'дата створення': qualificationsJSON[i][6],
                                'userId': qualificationsJSON[i][7],
                                'назва групи': qualificationsJSON[i][8],
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
                        app.gridData = qualificationsJSON;
                        // console.log(app.gridDataAll);
                        app.setUpPagination();
                    }
                };
                request.sendGETRequest("/euro_new/qualifications/", "");
        },
        addNewQualification: function() {
            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    console.log(request.xmlHttpRequestInstance.responseText);
                    app.updateAllQualifications();
                }
            };

            request.sendPOSTRequest("/euro_new/qualifications/", "");
        },
        deleteQualification: function () {

            var request = new HttpRequest();
            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    var responseText = request.xmlHttpRequestInstance.responseText;
                    console.log(responseText);
                    app.showDeleteEntryModal = false;
                    app.updateAllQualifications();
                    if (responseText === "") {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Запис успішно видалено',
                            showConfirmButton: false,
                            timer: 1500
                        })

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Упссс...',
                            text: 'Щось пішло не так!',
                            footer: '<a href>Повідомити адміністратору про помилку</a>'
                        })
                    }

                }
            }

            request.sendDELETERequest("/euro_new/qualifications/" + this.activeModalValue);
        },
        getActiveUser: function () {
            var cookies = document.cookie.split(';');
            var token = "";
            for (var i = 0; i < cookies.length; i++) {
                var tempCookie = cookies[i].split('=');
                if (tempCookie[0] === "PHPSESSID") {
                    token = tempCookie[1];
                    break;
                }
            }

            var request = new HttpRequest();

            request.xmlHttpRequestInstance.onreadystatechange = function (ev) {
                if (request.isRequestSuccessful()) {
                    var json = JSON.parse(request.xmlHttpRequestInstance.responseText);
                    app.isAdmin = json["is_admin"] === "1";
                    app.test();
                }
            };

            request.sendGETRequest("/euro_new/users?token=" + token, "")
        },
        test: function () {
            if (this.isAdmin) {
                console.log("TEst");
                Swal.fire({
                    title: 'Щось сталось ;)',
                    width: 600,
                    padding: '3em',
                    background: '#fff url(https://sweetalert2.github.io/images/trees.png)',
                    backdrop: 'rgba(0,0,123,0.4) url("views/images/nyan-cat.gif") left top no-repeat'
                })
            }
        }
    }
});