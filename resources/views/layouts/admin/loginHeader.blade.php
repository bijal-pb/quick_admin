<!DOCTYPE html>
<!--
Template Name:  SmartAdmin Responsive WebApp - Template build with Twitter Bootstrap 4
Version: 4.5.1
Author: Sunnyat A.
Website: http://gootbootstrap.com
Purchase: https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0?ref=myorange
License: You must have a valid license purchased only from wrapbootstrap.com (link above) in order to legally use this theme for your project.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        {{ config('app.name') }}
    </title>
    <meta name="description" content="Page Title">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print"
        href="{{ URL::asset('admin_assets/css/vendors.bundle.css') }}">
    <link id="appbundle" rel="stylesheet" media="screen, print"
        href="{{ URL::asset('admin_assets/css/app.bundle.css') }}">
    <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
    <link id="myskin" rel="stylesheet" media="screen, print"
        href="{{ URL::asset('admin_assets/css/skins/skin-master.css') }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ URL::asset('admin_assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ URL::asset('admin_assets/img/favicon/favicon.png') }}">
    <link rel="mask-icon" href="{{ URL::asset('admin_assets/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <link rel="stylesheet" media="screen, print"
        href="{{ URL::asset('admin_assets/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print"
        href="{{ URL::asset('admin_assets/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print"
        href="{{ URL::asset('admin_assets/css/notifications/toastr/toastr.css') }}">
    <link rel="stylesheet" media="screen, print"
        href="{{ URL::asset('admin_assets/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ URL::asset('admin_assets/css/page-login-alt.css') }}">
    {{-- <link rel="stylesheet" media="screen, print" href="{{ URL::asset('admin_assets/css/notifications/toastr/toastr.css')}}"> --}}
    <!-- You can add your own stylesheet here to override any styles that comes before it
  <link rel="stylesheet" media="screen, print" href="css/your_styles.css">-->
</head>
<!-- BEGIN Body -->
<!-- Possible Classes

  * 'header-function-fixed'         - header is in a fixed at all times
  * 'nav-function-fixed'            - left panel is fixed
  * 'nav-function-minify'			  - skew nav to maximize space
  * 'nav-function-hidden'           - roll mouse on edge to reveal
  * 'nav-function-top'              - relocate left pane to top
  * 'mod-main-boxed'                - encapsulates to a container
  * 'nav-mobile-push'               - content pushed on menu reveal
  * 'nav-mobile-no-overlay'         - removes mesh on menu reveal
  * 'nav-mobile-slide-out'          - content overlaps menu
  * 'mod-bigger-font'               - content fonts are bigger for readability
  * 'mod-high-contrast'             - 4.5:1 text contrast ratio
  * 'mod-color-blind'               - color vision deficiency
  * 'mod-pace-custom'               - preloader will be inside content
  * 'mod-clean-page-bg'             - adds more whitespace
  * 'mod-hide-nav-icons'            - invisible navigation icons
  * 'mod-disable-animation'         - disables css based animations
  * 'mod-hide-info-card'            - hides info card from left panel
  * 'mod-lean-subheader'            - distinguished page header
  * 'mod-nav-link'                  - clear breakdown of nav links

  >>> more settings are described inside documentation page >>>
 -->

<body class="mod-bg-1 ">
    <!-- DOC: script to save and load page settings -->
    <script>
        /**
         *	This script should be placed right after the body tag for fast execution 
         *	Note: the script is written in pure javascript and does not depend on thirdparty library
         **/
        'use strict';

        var classHolder = document.getElementsByTagName("BODY")[0],
            /** 
             * Load from localstorage
             **/
            themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
            themeURL = themeSettings.themeURL || '',
            themeOptions = themeSettings.themeOptions || ''
        projectName = themeSettings.projectName || '';


        if (themeURL == '' || projectName != '{{ config('app.name') }}') {
            var themeSet = {};
            themeSet.themeURL = '{{ config('app.url') }}' + '/admin_assets/css/themes/cust-theme-13.css';
            themeSet.themeOptions = 'mod-bg-1 mod-skin-light';
            themeSet.projectName = '{{ config('app.name') }}';
            localStorage.setItem('themeSettings', JSON.stringify(themeSet));

            themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
                {},
                themeURL = themeSettings.themeURL || '',
                themeOptions = themeSettings.themeOptions || '';
        }
        /** 
         * Load theme options
         **/
        if (themeSettings.themeOptions) {
            classHolder.className = themeSettings.themeOptions;
            console.log("%c✔ Theme settings loaded", "color: #148f32");
        } else {
            console.log("%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...",
                "color: #ed1c24");
        }
        if (themeSettings.themeURL && !document.getElementById('mytheme')) {
            var cssfile = document.createElement('link');
            cssfile.id = 'mytheme';
            cssfile.rel = 'stylesheet';
            cssfile.href = themeURL;
            document.getElementsByTagName('head')[0].appendChild(cssfile);

        } else if (themeSettings.themeURL && document.getElementById('mytheme')) {
            document.getElementById('mytheme').href = themeSettings.themeURL;
        }
        /** 
         * Save to localstorage 
         **/
        var saveSettings = function() {
            themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item) {
                return /^(nav|header|footer|mod|display)-/i.test(item);
            }).join(' ');
            if (document.getElementById('mytheme')) {
                themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
            };
            localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
        }
        /** 
         * Reset settings
         **/
        var resetSettings = function() {
            localStorage.setItem("themeSettings", "");
        }
    </script>
