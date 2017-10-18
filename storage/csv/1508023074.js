var app = angular.module('growSure', ['ngRoute']);


app.config(function ($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl: "app/views/dashboard.html"
    })
        .when("/Courses", {
            templateUrl: "app/views/course.html"
        })
        .when("/blog", {
            templateUrl: "app/views/blog.html"
        })
         .when("/about-us", {
             templateUrl: "app/views/about.html"
         })
         .when("/contact-us", {
             templateUrl: "app/views/contact.html"
         })

    .otherwise({
        redirect: '/'
    });;
});

app.config(function ($httpProvider) {
    $httpProvider.defaults.headers.common = {};
    $httpProvider.defaults.headers.post = {};
    $httpProvider.defaults.headers.put = {};
    $httpProvider.defaults.headers.patch = {};
});