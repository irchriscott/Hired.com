/*
 * THIS IS THE MAIN SCRIPTS FOR HIRED.com
 * Author : Ir Christian Scott
 * Date : 5th June, 2018
 */

const socket = io("127.0.0.1:8008");
let sessionID = null;
let sessionUsername = null;
let sessionName = null;

let markers = [];
let map;

$(document).ready(function () {

    $(window).scroll(function(){
        if ($(this).scrollTop() > 338) {
            $(".hd-profile-image").removeClass("animated fadeInDown").addClass("animated fadeOutUp").fadeOut();
            $(".hd-profile-user-menu").fadeIn().addClass("animated slideInUp");
        } else {
            $(".hd-profile-image").removeClass("animated fadeOutUp").fadeIn().addClass("animated fadeInDown");
            $(".hd-profile-user-menu").removeClass("slideInUp").fadeOut();
        }
        if ($(this).scrollTop() > 387) {
            $(".hd-menu-user").addClass("hd-menu-user-fix");
            $(".hd-row-col").addClass("hd-tab-margin");
            $("#hd-data-tab-content").addClass("hd-tab-margin-else");
        } else {
            $(".hd-menu-user").removeClass("hd-menu-user-fix");
            $(".hd-row-col").removeClass("hd-tab-margin");
            $("#hd-data-tab-content").removeClass("hd-tab-margin-else");
        }
    });

    var contID = $("body").find("#session_userid");
    var contName = $("body").find("#session_name");
    var contUsername = $("body").find("#session_username");

    if(contID.length > 0){
        sessionID = contID.val();
        sessionUsername = contUsername.val();
        sessionName = contName.val();
    }

    var window_width = $(window).width(),
        window_height = window.innerHeight,
        header_height = $(".default-header").height(),
        header_height_static = $(".site-header.static").outerHeight(),
        fitscreen = window_height - header_height;

    $(".fullscreen").css("height", window_height);
    $(".fitscreen").css("height", fitscreen);

    $(".default-header").sticky({
        topSpacing: 0
    });

    $('.active-works-carousel').owlCarousel({
        items: 1,
        loop: true,
        margin: 100,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 1
            }
        }
    });

    $('.active-testimonial').owlCarousel({
        items: 2,
        loop: true,
        margin: 20,
        dots: true,
        nav: true,
        navText: ["<span class='lnr lnr-arrow-up'></span>", "<span class='lnr lnr-arrow-down'></span>"],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 2
            }
        }
    });

    $('#type, #gender').niceSelect();
    $("#type").change(function(){
        if($(this).val() == 'User'){
            $("#hd-gender").show();
        } else {
            $("#hd-gender").hide();
        }
    });
    $('#hd-nav-menu').showMenu();
    $(".hd-data-menu-btn").showMenu();
    $("#hd-profile-description").froalaEditor(
        {
            placeholderText: "Describe Your Job Profile",
            toolbarInline: true,
            charCounterCount: false,
            toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'color', 'fontSize', '-', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'indent', 'outdent', '-', 'emoticons', 'specialCharacters', 'insertLink', 'undo', 'redo']
        }
    );
    $("#hd-job-description").froalaEditor({
        placeholderText: "Describe The Job or Service",
        toolbarInline: true,
        charCounterCount: false,
        toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'color', 'fontSize', '-', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'indent', 'outdent', '-', 'emoticons', 'specialCharacters', 'insertLink', 'undo', 'redo']
    });

    $("#hd-lg-text-message-input").froalaEditor({
        placeholderText: "Enter Text Message",
        toolbarInline: true,
        charCounterCount: false,
        toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'color', 'fontSize', '-', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'indent', 'outdent', '-', 'emoticons', 'specialCharacters', 'insertLink', 'undo', 'redo']
    });

    $("#hd-blog-description").froalaEditor({
        placeholderText: "Enter The Content Of Your Blog",
        toolbarInline: true,
        charCounterCount: false,
        toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'color', 'emoticons', '-', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'indent', 'outdent', '-', 'insertImage', 'insertLink', 'insertFile', 'insertVideo', 'undo', 'redo']
    });

    $("#hd-email-text").froalaEditor({
        placeholderText: "Enter Email Message",
        toolbarInline: true,
        charCounterCount: false,
        toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'color', 'fontSize', '-', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'indent', 'outdent', '-', 'emoticons', 'specialCharacters', 'insertLink', 'undo', 'redo']
    });

    $("#hd-preferences-body").searchPreferenceCategory();
    $("#hd-in-profile-images").change(function(){
        multipleImagesPreview(this, $("#hd-image-preview"));
    });
    $("#hd-in-cv").change(function(){
        getFileName(this, $("#hd-cv-name"));
    });
    $("#hd-upload-profile-files").submitUploadFiles();
    $("#profile-like-btn").submitLikeEvent();
    $("#job-like-btn").submitLikeEvent();
    $("#blog-like-btn").submitLikeEvent();
    $("#hd-show-review-model").click(function(e){
        e.preventDefault();
        $("#hd-review-profile").modal('show');
    });
    $("#hd-show-suggestion-model").click(function(e){
        e.preventDefault();
        $("#hd-suggest-job").modal('show');
    });
    $("#hd-profile-review-form").submitComment();
    $("#specify").change(function () {
        if ($(this)[0].checked === true) {
            $("#general").hide();
            $("#specific").show();
            $("#hd-job-duration").val("1");
        } else {
            $("#general").show();
            $("#specific").hide();
            var value = $("#hd-job-duration").attr("data-value");
            $("#hd-job-duration").val(value);
        }
    });
    $("#hd-from-date, #hd-to-date").datepicker({
        startDate: '1d',
        format: 'dd-mm-yyyy'
    });
    $("#delete-submit-btn").deleteSubmit();
    $("#hd-filter-categories").scrollCategories();
    $("#hd-categories ul li").click(function(){
        var url = $(this).attr("data-url");
        var type = $(this).attr("data-type");
        $(this).addClass("active").siblings().removeClass("active");
        $("#hd-filter-data-input").attr("data-type", type).attr("data-url", url);
        loadHTMLAjax("hd-jb-container-data", url);
    });
    $("#hd-subcategories ul li").click(function(){
        var profilesURL = $(this).attr("data-profiles");
        var jobsURL = $(this).attr("data-jobs");
        var servicesURL = $(this).attr("data-services");
        var blogsURL = $(this).attr("data-blogs");
        $(this).addClass("active").siblings().removeClass("active");
        loadHTMLAjax("hd-container-data-profiles", profilesURL);
        loadHTMLAjax("hd-container-data-jobs", jobsURL);
        loadHTMLAjax("hd-container-data-services", servicesURL);
        loadHTMLAjax("hd-container-data-blogs", blogsURL);
    });
    $("#hd-filter-data-input").searchHome();
    $("#hd-datetime-in").setDate();
    $("#hd-read-all-notifs").deleteOrReadNotification();
    $("#hd-open-profile-img-input").click(function(e){
        e.preventDefault();
        $("#hd-profile-img-input").click();
    });
    $("#hd-profile-img-input").change(function(){
        updateProfileImage(this);
    });
    $("#hd-session-profile-image-update").submitImage();
    $("#hd-text-message-form").messageText();
    $("#hd-text-message-lg-form").messageText();
    $("#hd-images-message-form").messageText();
    $("#hd-location-message-form").messageText();
    $("#hd-show-lg-message-model, #hd-show-images-message-model").click(function (e) {
        e.preventDefault();
        $($(this).attr("href")).modal('show');
    });
    $("#hd-show-location-message-model").click(function(e){
        e.preventDefault();
        getUserCurrentLocation("hd-message-latitude", "hd-message-longitude", "hd-message-address", "");
        setTimeout(function(){
            initMapUser();
        }, 1000);
        $($(this).attr("href")).modal('show');
    });

    $("#hd-profile-hire-form").submit(function(){
        emitNotificationSocket($(this).attr("data-owner"));
    });
    $("#hd-profile-suggest-form").submit(function () {
        emitNotificationSocket($(this).attr("data-owner"));
    });

    socket.on("getNotification", function(owner){
        if(sessionID == owner){
            var contNot = $("body").find("#hd-session-notifications");
            contNot.fadeIn().addClass('animated zoomIn');
            contNot.text(parseInt(contNot.text()) + 1);
        }
    });

    socket.on("getLike", function(like){
        var likeBtn = $("body").find(".hd-like-btn");
        if(like.user != sessionID){
            if(likeBtn.length > 0){
                if(likeBtn.attr("data-from") == like.from && likeBtn.attr("data-id") == like.id){
                    var sumLikes = $("#like-sum");
                    sumLikes.text(parseInt(sumLikes.text()) + 1);
                    loadHTMLAjax("hd-profile-likes-loader", like.url);
                }
            }
            if(like.owner == sessionID){
                iziToast.info({
                    id: like.name,
                    timeout: 5000,
                    title: capitalize(like.name),
                    message: "Has Liked Your " + capitalize(like.from) + " !!!",
                    position: 'bottomLeft',
                    transitionIn: 'bounceInLeft',
                    close: false,
                });
            }
        }
    });

    socket.on("getComment", function(comment){
        var formCont = $("body").find(".hd-comment-form");
        if (comment.user != sessionID) {
            if (formCont.length > 0) {
                if (formCont.attr("data-from") == comment.from && formCont.attr("data-id") == comment.id) {
                    var sumComments = $("#hd-sum-comments");
                    sumComments.text(parseInt(sumComments.text()) + 1);
                    loadHTMLAjax(comment.container, comment.url);
                }
            }
            if (comment.owner == sessionID) {
                if(comment.from == "blog"){
                    iziToast.info({
                        id: comment.name,
                        timeout: 5000,
                        title: capitalize(comment.name),
                        message: "Has Responded To Your Blog !!!",
                        position: 'bottomLeft',
                        transitionIn: 'bounceInLeft',
                        close: false,
                    });
                } else {
                    iziToast.info({
                        id: comment.name,
                        timeout: 5000,
                        title: capitalize(comment.name),
                        message: (comment.from == "profile") ? "Has Made A Review On Your " + capitalize(comment.from) + " !!!" : "Has Commented On Your " + capitalize(comment.from) + " !!!",
                        position: 'bottomLeft',
                        transitionIn: 'bounceInLeft',
                        close: false,
                    });
                }
            }
        }
    });

    socket.on("isTyping", function (data) {
        var form = $("body").find("#hd-text-message-form");
        if (data.receiver == sessionID) {
            if (form.length > 0) {
                var paragraph = $("#hd-type-status");
                if (data.message != "") {
                    paragraph.fadeIn().children("p").text(capitalize(data.sender) + " is typing...")
                } else {
                    paragraph.fadeOut().children("p").text("");
                }
            }
        }
        console.log(data);
        console.log(form.length);
        console.log(sessionID);
    });

    socket.on("getMessage", function (message) {
        var form = $("body").find("#hd-text-message-form");
        if (message.receiver == sessionID) {
            if (form.length > 0) {
                loadHTMLAjax("hd-chat-messages-container", message.path);
                updateMessageScroll();
            } else {
                iziToast.info({
                    id: message.sender,
                    timeout: 8000,
                    title: capitalize(message.sender),
                    message: message.message,
                    position: 'bottomLeft',
                    transitionIn: 'bounceInLeft',
                    close: false,
                });
            }
            loadHTMLAjax("hd-messages-all", message.loader);
        } else if (message.sender == sessionUsername) {
            loadHTMLAjax("hd-chat-messages-container", message.url);
            loadHTMLAjax("hd-messages-all", message.loader);
            updateMessageScroll();
        }
    });

});

function capitalize(text){
    return text.replace(text.charAt(0), text.charAt(0).toUpperCase())
}

jQuery.fn.showMenu = function () {
    var id = $(this).attr("data-id");
    $(window).click(function () {
        $("#hd-menu-" + id).hide();
    });
    $("#hd-menu-" + id).click(function (ev) {
        ev.stopPropagation();
    });
    $(this).click(function (ev) {
        ev.stopPropagation();
        $("#hd-menu-" + id).show();
    });
}

jQuery.fn.searchPreferenceCategory = function(){

    const _this = $(this);
    const catInput = _this.find("#hd-add-preferences");
    const subcatInput = _this.find("#hd-add-sub-preferences");
    
    const catContainer = _this.find("#hd-categories-container");
    const catContainerList = catContainer.find("ul");
    const subcatContainer = _this.find("#hd-subcategories-container");
    const subcatContainerList = subcatContainer.find("ul");

    const collapseCategories = catContainer.find("a");
    const collapseSubcategories = subcatContainer.find("a");
    
    const catSpinner = _this.find("#hd-spinner");
    const subcatSpinner = _this.find("#hd-spinner-else");
    const badgesContainer = _this.find("#hd-form-badges");

    const closeAddPreferences = _this.find("#hd-close-add-preferences");
    const savePreferences = _this.find("#hd-save-prefernces");
    const token = _this.find("input[name=_token]");
    const urlCheck = _this.attr("url-check");
    const urlSubmit = _this.attr("url-submit");
    const urlLoad = _this.attr("url-load");
    
    var canHide = false;
    var category;
    var subcategories = [];
    var preferences = [];

    function loadExistingPreferences(){
        jQuery.ajax({
            type: "GET",
            url: urlCheck,
            data: {},
            success: function(response){
                preferences = response;
            },
            error: function(error){
                showErrorMessage("error", error);
            }
        }, function(error){
            showErrorMessage("error", error);
        });
    }

    catInput.on('focusin', function () {

        _this.find("#hd-categories-container").show();
        catSpinner.show();
        loadExistingPreferences();

        $.ajax({
            type: 'GET',
            url: '/categories/all/json',
            data: {},
            success: function(response){
                catContainerList.empty();
                catSpinner.hide();
                response.forEach((data) => {
                    var element = $("<li>" + categoryTemplate(data) + "</li>");
                    element.attr("data-id", data.id);
                    element[0].addEventListener('click', function(){
                        category = data.id;
                        catInput.val(data.name);
                        catContainer.hide();
                        catContainerList.empty();
                        catInput.attr("disabled", "disabled");
                        subcatInput.removeAttr("disabled").show();
                        subcatInput.focus();
                    });
                    catContainerList.append(element);
                });
            },
            error: function(error){
                showErrorMessage("error", error);
            }
        }, function(error){
            showErrorMessage("error", error);
        });

        catInput.attr("placeholder", "");
    });

    _this.children("#hd-categories-container").on('click, foucusout', function(e){
        e.stopPropagation();
    });

    catInput.on('focusout', function () {
        if(canHide){
            catInput.attr("placeholder", "Search Category Preference");
            catContainer.hide();
            catContainer.empty();
            catSpinner.hide();
        }
    });

    catInput.on('keyup', function (e) {
        $.ajax({
            type: "GET",
            url: "/categories/filter/json",
            data: {"query":catInput.val()},
            success: function(response){
                catContainerList.empty();
                if(response.length > 0){
                    catSpinner.hide();
                    response.forEach((data) => {
                        var element = $("<li>" + categoryTemplate(data) + "</li>");
                        element.attr("data-id", data.id);
                        element[0].addEventListener('click', function () {
                            category = data.id;
                            catInput.val(data.name);
                            catContainer.hide();
                            catContainerList.empty();
                            catInput.attr("disabled", "disabled");
                            subcatInput.removeAttr("disabled").show();
                            subcatInput.focus();
                        });
                        catContainerList.append(element);
                    });
                } else {
                    catSpinner.show();
                }
            },
            error: function(error){
                showErrorMessage("error", error);
            }
        }, function(error){
            showErrorMessage("error", error);
        });
    });

    collapseCategories.click(function(e){
        e.preventDefault();
        catContainerList.empty();
        catContainer.hide();
        catSpinner.hide();
    });

    subcatInput.on('focus', function(){
        subcatSpinner.show();
        subcatContainer.show();
        setTimeout(function(){
            subcatInput.attr("placeholder", "");
        }, 3000);
    });

    subcatInput.on('focusout', function(){});

    subcatInput.on('keyup', function(){
        jQuery.ajax({
            type: "GET",
            url: "/category/" + category + "/subcategories/filter/json",
            data: {"query": subcatInput.val()},
            success: function(response){
                subcatContainerList.empty();
                if(response.length > 0){
                    subcatSpinner.hide();
                    response.forEach((data) => {
                        var element = $("<li>" + subcatgoryTemplate(data) + "</li>");
                        element.attr("data-id", data.id);
                        element[0].addEventListener('click', function () {
                            var badgeTemplate = $('<div data-id="' + data.id + '" class="hd-badge"><div class="hd-badge-content"><span class="hd-b-icon">' + data.icon + '</span><span class="hd-b-text"><a href="#">' + data.name + '</a></span><span class="hd-b-remove"><span class="lnr lnr-cross"></span></span></div></div>');
                            subcatInput.val("");
                            badgeTemplate.find(".hd-b-remove").click(function(){
                                badgeTemplate.hide();
                                subcategories = subcategories.filter(function(i){
                                    return i !== data.id;
                                });
                            });
                            if (subcategories.includes(data.id) === false && preferences.includes(data.id) === false) {
                                badgesContainer.append(badgeTemplate);
                                subcategories.push(data.id);
                            } else {
                                showErrorMessage("error", "Subcategory Already Selected !!!");
                            }
                        });
                        subcatContainerList.append(element);
                    });
                } else {
                    subcatSpinner.show();
                }
            },
            error: function(error){
                showErrorMessage("error", error);
            }
        }, function(error){
            showErrorMessage("error", error);
        });
    });

    collapseSubcategories.click(function(e){
        e.preventDefault();
        subcatContainer.hide();
        subcatContainerList.empty();
    });

    savePreferences.click(function(e){
        e.preventDefault();
        jQuery.ajax({
            type: 'POST',
            url: urlSubmit,
            data: {
                "category": category,
                "preferences": subcategories,
                "_token": token.val()
            },
            success: function(response){
                if(response.type == "success"){
                    showSuccessMessage(response.type, response.text);
                    loadExistingPreferences();
                    loadHTMLAjax("hd-profile-preferences", urlLoad);
                    reset();
                } else {    
                    showErrorMessage(response.type, response.text);
                }
            },
            error: function(error){
                showErrorMessage("error", error);
            }
        }, function(error){
            showErrorMessage("error", error);
        });
    });

    closeAddPreferences.click(function(){
        reset();
    });

    function reset(){
        catContainer.hide();
        catContainerList.empty();
        catInput.removeAttr("disabled");
        catInput.attr("placeholder", "Search Category Preference");
        catInput.val("");
        catSpinner.hide();

        subcatContainer.hide();
        subcatContainerList.empty();
        subcatInput.hide();
        subcatInput.attr("placeholder", "Search Subcategory Preference");
        subcatInput.val("");
        subcatSpinner.hide();

        category = 0;
        subcategories = [];
        preferences = [];
        badgesContainer.empty();

        $("#hd-add-peferences").modal('hide');
    }
}

function categoryTemplate(data){
    return `
        <div data-id="${data.id}">
            <div class="hd-image">
                <img src="${data.image}" />
            </div>
            <div class="hd-about">
				<h4 class="text-ellipsis">${data.name}</h4>
                <p class="text-ellipsis">${data.description}</p>
				<div class="meta-bottom d-flex justify-content-between">
					<p><span class="lnr lnr-user"></span> ${data.profiles} Profiles</p>
					<p><span class="lnr lnr-briefcase"></span> ${data.jobs} Jobs</p>
					<p><span class="lnr lnr-layers"></span> ${data.subcategories} Subcategories</p>
				</div>
			</div>
        </div>`;
}

function subcatgoryTemplate(data){
    return `
        <div data-id="${data.id}">
            <div class="hd-image">
                <span class="hd-subcat-icon">${data.icon}</span>
            </div>
            <div class="hd-about">
				<h4 class="text-ellipsis">${data.name}</h4>
                <p class="text-ellipsis">${data.description}</p>
				<div class="meta-bottom d-flex justify-content-between">
					<p><span class="lnr lnr-user"></span> ${data.profiles} Profiles</p>
					<p><span class="lnr lnr-briefcase"></span> ${data.jobs} Jobs</p>
				</div>
			</div>
        </div>`;
}

jQuery.fn.deleteDataAJAX = function () {
    
    const _this = $(this);
    const deleteBtn = $(this).find(".hd-remove-btn");
    const _id = $(this).attr("data-id");
    const _url = $(this).attr("data-url");
    const _loader = $(this).attr("data-loader");
    const token = $(this).find("input[name=_token]");
    const item = $(this).attr("data-item");
    const container = $(this).attr("data-container");

    deleteBtn.click(function(e){
        e.preventDefault();
        iziToast.question({
            timeout: 10000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: 'question',
            zindex: 999,
            title: 'Delete Profile ' + item,
            message: 'Do you realy want to remove this ' + item.toLowerCase() + ' ?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');

                    jQuery.ajax({
                        type: "POST",
                        url: _url,
                        data: {
                            "_token": token.val(),
                            "_method": "DELETE",
                            "id": _id
                        },
                        success: function(response){
                            if(response.type == "success"){
                                showSuccessMessage(response.type, response.text);
                                loadHTMLAjax(container, _loader);
                                _this.hide();
                            } else {
                                showErrorMessage(response.type, response.text);
                            }
                        },
                        error: function(error){
                            showErrorMessage("error", error);
                        }
                    }, function(error){
                        showErrorMessage("error", error);
                    });
                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');
                    showInfoMessage("info", "Operation Cancelled !!!");
                }],
            ],
            onClosing: function (instance, toast, closedBy) {},
            onClosed: function (instance, toast, closedBy) {
                showInfoMessage("info", "Operation Cancelled !!!");
            }
        });
    });
}

jQuery.fn.submitUploadFiles = function(){

    const _this = $(this);

    $(this).submit(function(e){
        e.preventDefault();
        var _url = $(this).attr("action");
        var _data = new FormData($(this)[0]);
        var loader = $(this).attr("data-url");
        _this.find("button").attr("disabled", "disabled");
        jQuery.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                $("#hd-files-upload-progress").show();
                xhr.upload.addEventListener("progress", function (e) {
                    if (e.lengthComputable) {
                        var percent = Math.round((e.loaded / e.total) * 100);
                        $("#progress-bar").attr("aria-valuenow", percent).css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },
            type: 'POST',
            url: _url,
            data: _data,
            processData: false,
            contentType: false,
            success: function(response){
                _this.find("button").removeAttr("disabled");
                if(response.type == "success"){
                    _this[0].reset();
                    resetUpload();
                    loadHTMLAjax("hd-load-img-ex", loader);
                    showSuccessMessage(response.type, response.text);
                } else {
                    showErrorMessage(response.type, response.text);
                }
            },
            error: function(error){
                resetUpload();
                showErrorMessage("error", error);
            }
        }, function(error){
            resetUpload();
            showErrorMessage("error", error);
        });
    });

    function resetUpload(){
        $("#hd-files-upload-progress").hide();
        $("#progress-bar").attr("aria-valuenow", 0).css('width', '0%').text('0%');
        $("#hd-image-preview").empty().hide();
        _this.find("button").removeAttr("disabled");
    }

}

jQuery.fn.setReviewStars = function(value){
    const stars = $(this).find("input[name=star]");
    if(value < 6){
        for(const star of stars){
            if($(star).val() == value){
                $(star).attr("checked", true);
            }
        }
    } else {
        $(stars[0]).attr("checked", true);
    }
}

jQuery.fn.submitLikeEvent = function(){
    $(this).click(function(e){
        var token = $(this).find("input[name=_token]").val();
        var action = $(this).attr("data-url");
        var profile = $(this).attr("data-id");
        var user = $(this).attr("data-user");
        var likeText = $("#hd-number-add");
        var sumLikes = $("#like-sum");
        var _url = $(this).attr("data-loader");
        var from = $(this).attr("data-from");
        var owner = $(this).attr("data-owner");

        if(parseInt(user) > 0){
            $.ajax({
                type: "POST",
                url: action,
                data: {
                    "_token": token,
                    "profile": profile
                },
                success: function(response){
                    if(response.type == "like"){
                        showSuccessMessage(response.type, response.text);
                        likeText.text("+1").fadeIn().addClass('animated zoomIn').fadeOut();
                        sumLikes.text(parseInt(sumLikes.text()) + 1);
                        loadHTMLAjax("hd-profile-likes-loader", _url);
                        socket.emit("like", {"id":profile, "user": sessionID, "name":sessionName, "from":from, "owner":owner, "url": _url});
                        socket.emit("setNotification", owner);
                    } else if(response.type == "dislike"){
                        likeText.text("-1").fadeIn().addClass('animated zoomIn').fadeOut();
                        showSuccessMessage(response.type, response.text);
                        sumLikes.text(parseInt(sumLikes.text()) - 1);
                        loadHTMLAjax("hd-profile-likes-loader", _url);
                    } else {
                        showErrorMessage(response.type, response.text);
                    }
                },
                error: function(error){
                    showErrorMessage("error", error);
                }
            }, function(error){
                showErrorMessage("error", error);
            });
        } else {
            e.preventDefault();
            showErrorMessage("error", "Please, Login !!!");
        }   

    });
}

jQuery.fn.submitComment = function(){
    $(this).submit(function(e){
        e.preventDefault();
        const action = $(this).attr("action");
        const url = $(this).attr("data-url");
        const container = $(this).attr("data-container");
        var _data = new FormData($(this)[0]);
        const id = $(this).attr("data-id");
        const owner = $(this).attr("data-owner");
        const from = $(this).attr("data-from");

        $.ajax({
            type: 'POST',
            data:_data,
            url: action,
            processData: false,
            contentType: false,
            success: function(response){
                if (response.type == "success"){
                    loadHTMLAjax(container, url);
                    $("#hd-review-profile").modal('hide');
                    $("#hd-review-edit-" + id).modal('hide');
                    $("#hd-comment-edit-" + id).modal('hide');
                    $("#hd-response-edit-" + id).modal('hide');
                    socket.on("comment", {"id":id, "user":sessionID, "owner":owner, "from":from, "url":url, "container":container});
                    socket.on("setNotification", owner);
                    showSuccessMessage(response.type, response.text);
                } else {
                    showErrorMessage(response.type, response.text);
                }
            },
            error: function(error){
                showErrorMessage("error", error);
            }
        }, function(error){
            showErrorMessage("error", error);
        });
    });
}

jQuery.fn.deleteWithMenu = function(){

    $(this).click(function(e){
        e.preventDefault();
        const action = $(this).attr("action");
        const _url = $(this).attr("data-url");
        const container = $(this).attr("data-container");
        const item = $(this).attr("data-item");
        const _id = $(this).attr("data-id");
        const token = $(this).find("input[name=_token]");

        iziToast.question({
            timeout: 10000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: 'question',
            zindex: 999,
            title: 'Delete Profile ' + item,
            message: 'Do you realy want to delete this ' + item.toLowerCase() + ' ?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');

                    jQuery.ajax({
                        type: "POST",
                        url: action,
                        data: {
                            "_token": token.val(),
                            "_method": "DELETE",
                            "id": _id
                        },
                        success: function (response) {
                            if (response.type == "success") {
                                showSuccessMessage(response.type, response.text);
                                loadHTMLAjax(container, _url);
                            } else {
                                showErrorMessage(response.type, response.text);
                            }
                        },
                        error: function (error) {
                            showErrorMessage("error", error);
                        }
                    }, function (error) {
                        showErrorMessage("error", error);
                    });
                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');
                    showInfoMessage("info", "Operation Cancelled !!!");
                }],
            ],
            onClosing: function (instance, toast, closedBy) { },
            onClosed: function (instance, toast, closedBy) {
                showInfoMessage("info", "Operation Cancelled !!!");
            }
        });
    });
}

jQuery.fn.deleteSubmit = function(){
    $(this).click(function(e){
        e.preventDefault();
        var item = $(this).attr("data-item");
        iziToast.question({
            timeout: 10000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: 'question',
            zindex: 999,
            title: 'Delete ' + item,
            message: 'Do you realy want to delete this ' + item.toLowerCase() + ' ?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');
                    $("#hd-delete-form").submit();
                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');
                    showInfoMessage("info", "Operation Cancelled !!!");
                }],
            ],
            onClosing: function (instance, toast, closedBy) {},
            onClosed: function (instance, toast, closedBy) {
                showInfoMessage("info", "Operation Cancelled !!!");
            }
        });
    });
}

jQuery.fn.updateSuggestionStatus = function(){
    $(this).click(function(e){
        e.preventDefault();
        const action = $(this).attr("action");
        const _url = $(this).attr("data-url");
        const container = $(this).attr("data-container");
        const status = $(this).attr("data-status");
        const _id = $(this).attr("data-id");
        const token = $(this).find("input[name=_token]");
        const owner = $(this).attr("data-owner");

        iziToast.question({
            timeout: 10000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: 'question',
            zindex: 999,
            title: 'Update Suggestion Status',
            message: 'Do you realy want to update this suggestion status to ' + status.toUpperCase() + ' ?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');

                    jQuery.ajax({
                        type: "POST",
                        url: action,
                        data: {
                            "id": _id,
                            "_token": token.val(),
                            "status": status,
                            "_method":"PATCH"
                        },
                        success: function (response) {
                            if (response.type == "success") {
                                showSuccessMessage(response.type, response.text);
                                loadHTMLAjax(container, _url);
                                socket.on("setNotification", owner);
                            } else {
                                showErrorMessage(response.type, response.text);
                            }
                        },
                        error: function (error) {
                            showErrorMessage("error", error);
                        }
                    }, function (error) {
                        showErrorMessage("error", error);
                    });

                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');
                    showInfoMessage("info", "Operation Cancelled !!!");
                }],
            ],
            onClosing: function (instance, toast, closedBy) {},
            onClosed: function (instance, toast, closedBy) {
                showInfoMessage("info", "Operation Cancelled !!!");
            }
        });
    });
}

jQuery.fn.updateSuggestionStatusElse = function () {
    $(this).click(function (e) {
        e.preventDefault();
        const action = $(this).attr("href");
        const status = $(this).attr("data-status");
        const owner = $(this).attr("data-owner");

        iziToast.question({
            timeout: 10000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: 'question',
            zindex: 999,
            title: 'Update Suggestion Status',
            message: 'Do you realy want to update this suggestion status to ' + status.toUpperCase() + ' ?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');

                    socket.on("setNotification", owner);
                    window.location = action;

                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');
                    showInfoMessage("info", "Operation Cancelled !!!");
                }],
            ],
            onClosing: function (instance, toast, closedBy) {},
            onClosed: function (instance, toast, closedBy) {
                showInfoMessage("info", "Operation Cancelled !!!");
            }
        });
    });
}

jQuery.fn.deleteOrReadNotification = function () {
    $(this).click(function (e) {
        e.preventDefault();
        const action = $(this).attr("href");
        const item = $(this).attr("data-item");
        iziToast.question({
            timeout: 10000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: 'question',
            zindex: 999,
            title: (item == "delete") ? 'Delete Notification' : 'Read All Notifications',
            message: (item == "delete") ? 'Do you realy want to delete this notification ?' : 'Do you really want to mark all notifications as read ?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');

                    window.location = action;

                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOut'
                    }, toast, 'button');
                    showInfoMessage("info", "Operation Cancelled !!!");
                }],
            ],
            onClosing: function (instance, toast, closedBy) {},
            onClosed: function (instance, toast, closedBy) {
                showInfoMessage("info", "Operation Cancelled !!!");
            }
        });
    });
}

jQuery.fn.searchHome = function(){
    $(this).keyup(function(){
        var action = $(this).attr("data-url");
        jQuery.ajax({
            type: "GET",
            data: {"query": $(this).val()},
            url: action,
            success: function(response){
                $("#hd-jb-container-data").html(response);
            },
            error: function(error){
                showErrorMessage("error", error);
            }
        }, function(error){
            showErrorMessage("error", error);
        });
    });
}

jQuery.fn.scrollCategories = function(){
    const leftBtn = $(this).find("#hd-left-btn");
    const rightBtn = $(this).find("#hd-right-btn");
    const container = $(this).find(".hd-categories");
    const listLength = $(this).find("li").length;
    let slideCount = 0;
    let width = 0;
    const slideTime = 500;

    container.find("li").each(function () {
        width += $(this).width() + 57;
    });
    
    let slideWidth = width - container.width();
    let mesure = (slideWidth / listLength) * 2;

    leftBtn.click(function(){
        if (slideCount > 0) {
            container.find("ul").animate({
                marginLeft: '+=' + mesure + 'px'
            }, slideTime);
            slideCount--;
            slideWidth = slideWidth + mesure;
        }
    });

    rightBtn.click(function(){
        if (slideWidth > 0) {
            container.find("ul").animate({
                marginLeft: '-=' + mesure + 'px'
            }, slideTime);
            slideCount++;
            slideWidth = slideWidth - mesure;
        }
    });
}

function resetImage(){
    $("#hd-image-overlay").css('opacity', '0');
    $("#hd-image-icon").show();
    $("#hd-image-load").hide();
}

jQuery.fn.submitImage = function(){
    $(this).submit(function(e){
        e.preventDefault();
        var action = $(this).attr("action");
        var data = new FormData($(this)[0]);
        var image = $(this).attr("data-image");
        jQuery.ajax({
            type:'POST',
            data: data,
            url: action,
            processData: false,
            contentType: false,
            success: function(response){
                showSuccessMessage(response.type, response.text);
                resetImage();
            },
            error: function(error){
                showErrorMessage("error", error);
                resetImage();
                $("#hd-profile-image").attr("src", image);
            }
        }, function(error){
            showErrorMessage("error", error);
            $("#hd-profile-image").attr("src", image);
        });
    });
}

jQuery.fn.closePopup = function () {
    $(this).click(function (e) {
        e.preventDefault();
        $("body").find(".mfp-close").click();
    });
}

jQuery.fn.openImageGallery = function () {
    $(this).click(function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var items = $("#hd-image-gallery-" + id);
        var list = items.find("a");
        var first = list.get(0);
        first.click();
    });
}

jQuery.fn.imagesGallery = function () {
    $(this).magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            titleSrc: function (item) {
                return item.el.attr('title');
            }
        },
        gallery: {
            enabled: true
        }
    });
}

jQuery.fn.messageText = function () {

    var _this = $(this);
    var url = _this.attr("data-url");
    var receiver = _this.attr("data-receiver");
    var sender = _this.attr("data-sender");
    var path = _this.attr("data-path");
    var loader = _this.attr("data-loader");

    _this.find("textarea").keyup(function () {
        var value = $(this).val();
        if (value != "") {
            _this.find("button").removeAttr("disabled").children("i").addClass("yb-btn-color");
        } else {
            _this.find("button").attr("disabled", "disabled").children("i").removeClass("yb-btn-color");
        }
        emitTypeTextSocket(value, _this);
    });

    _this.find("input[type=file]").change(function () {
        multipleImagesPreview(this, $("#hd-image-preview"));
        var value = $(this).val();
        if (value != null) {
            _this.find("button[type=submit]").removeAttr("disabled").children("span").addClass("yb-btn-color");
        } else {
            _this.find("button[type=submit]").attr("disabled", "disabled").children("span").removeClass("yb-btn-color");
        }
        emitTypeTextSocket(value, _this);
    });

    _this.find("button[type=button]").click(function (e) {
        e.preventDefault();
        emitTypeTextSocket("", _this);
    });

    _this.submit(function (e) {
        e.preventDefault();
        var data = new FormData(_this[0]);
        var action = _this.attr("action");
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                $("#hd-files-upload-progress").show();
                xhr.upload.addEventListener("progress", function (e) {
                    if (e.lengthComputable) {
                        var percent = Math.round((e.loaded / e.total) * 100);
                        $("#progress-bar").attr("aria-valuenow", percent).css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },
            type: "POST",
            url: action,
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.type == 'success'){
                    var message = {
                        "receiver": receiver,
                        "sender": sender,
                        "message": response.text,
                        "url": url,
                        "path": path,
                        "loader": loader
                    }
                    socket.emit("messageSent", message);
                    _this.find("[data-dismiss=modal]").click();
                    resetMessage();
                }
            },
            error: function (error) {
                showErrorMessage("error", error);
            }
        });
    });

    _this.find("[data-dismiss=modal]").click(function(){
        resetMessage();
    });

   _this.keypress(function(e){
       var key = e.charCode || e.keyCode || 0;
       if (key == 13) {
           e.preventDefault();
       }
   });

    _this.find("#hd-message-address").keyup(function(e){
        var key = e.charCode || e.keyCode || 0;
        if(key == 13){
            e.preventDefault();
            var address = $(this).val();
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var from_lat = results[0].geometry.location.lat();
                    var from_long = results[0].geometry.location.lng();

                    $("#hd-message-latitude").val(from_lat);
                    $("#hd-message-longitude").val(from_long);
                }
            });
            setTimeout(function(){
                initMapUser();
            }, 1000);
        }
    });

    function resetMessage(){
        emitTypeTextSocket("", _this);
        _this.children("textarea").val("");
        _this.children("input[type=file]").val(null);
        $("#hd-image-preview").empty().hide();
        $("#hd-files-upload-progress").hide();
        $("#progress-bar").attr("aria-valuenow", 0).css('width', '0%').text('0%');
    }
}

function emitTypeTextSocket(message, data) {
    var data = {
        "receiver": data.attr("data-receiver"),
        "sender": data.attr("data-sender"),
        "message": message,
    }
    socket.emit("textType", data);
}

function showErrorMessage(id, message) {
    iziToast.error({
        id: id,
        timeout: 5000,
        title: 'Error',
        message: message,
        position: 'bottomLeft',
        transitionIn: 'bounceInLeft',
        close: false
    });
}

function showSuccessMessage(id, message) {
    iziToast.success({
        id: id,
        timeout: 5000,
        title: 'Success',
        message: message,
        position: 'bottomLeft',
        transitionIn: 'bounceInLeft',
        close: false
    });
}

function showInfoMessage(id, message) {
    iziToast.info({
        id: id,
        timeout: 5000,
        title: 'Info',
        message: message,
        position: 'bottomLeft',
        transitionIn: 'bounceInLeft',
        close: false
    });
}

function loadHTMLAjax(container, url){
    setTimeout(function () {
        $("#" + container).load(url, function () {
            $(this).children(".hd-spinner").hide();
            updateMessageScroll();
        }, function (error) {
            showErrorMessage("error", error);
        });
    });
}

function multipleImagesPreview(input, container) {
    container.empty();
    if (input.files) {
        var filesAmount = input.files.length;
        container.show();
        var images = new Array();
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function (event) {
                var image = $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(container);
                images.push(image[0].clientHeight)
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
}

function getFileName(input, container){
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var ext = $(input).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['xls', 'pdf', 'doc', 'docx']) > 0) {
                container.text($(input).val());
            } else {
                showErrorMessage("doc", "Only pdf, doc and docx documents allowed !!!");
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function updateProfileImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var ext = $(input).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'jpg', 'png', 'jpeg']) > 0) {
                $("#hd-profile-image").attr("src", e.target.result);
                $("#hd-image-overlay").css('opacity', '1');
                $("#hd-image-icon").hide();
                $("#hd-image-load").show();
                $("#hd-session-profile-image-update").submit();
            } else {
                showErrorMessage("image", "Only jpg, png and jpeg images allowed !!!");
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

jQuery.fn.setDate = function () {
    setInterval(() => {
        var time = $(this).attr("data-date");
        var utc_timestamp = (Date.parse(time)) - (new Date().getTimezoneOffset() * 60 * 1000);

        var post_time = utc_timestamp / 1000;
        var timee = utc_timestamp;
        var current_time = Math.floor(jQuery.now() / 1000);

        real_time = (current_time - post_time);
        if (real_time < 60) {
            $(this).text('Just Now');
        } else if (real_time >= 60 && real_time < 3600) {
            time_be = moment(timee).fromNow();
            $(this).text(time_be);
        } else if (real_time >= 3600 && real_time < 86400) {
            time_be = moment(timee).fromNow();
            $(this).text(time_be);
        } else if (real_time >= 86400 && real_time < 604800) {
            time_b = Math.floor(real_time / (60 * 60 * 24));
            time_be = moment(timee).calendar();
            $(this).text(time_be);
        } else if (real_time >= 604800 && real_time < 31104000) {
            time_be = moment(timee).format('MMMM Do [at] h:mm a');
            $(this).text(time_be);
        } else {
            time_be = moment(timee).format('DD MMM YYYY [at] h:mm a');
            $(this).text(time_be);
        }
        return false;
    }, 100)
}

function emitNotificationSocket(owner){
    socket.on("setNotification", owner);
}

function updateMessageScroll() {
    var message_list = $("#hd-chat-messages-container");
    message_list.scrollTop = message_list.scrollHeight;
    $("#hd-chat-messages-container").animate({
        scrollTop: 100000000
    }, 1000);
}

function getUserCurrentLocation(lat, long, addr, where) {

    if (!navigator.geolocation) {
        return showErrorMessage('error_geolocation', 'Geolocation not supported by your browser');
    }
    navigator.geolocation.getCurrentPosition(function (position) {

        var geocoder = new google.maps.Geocoder();
        var location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

        geocoder.geocode({
            'latLng': location
        }, function (results, status) {

            if (status == google.maps.GeocoderStatus.OK) {

                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                var address = results[0].formatted_address;

                var length = results[0].address_components.length;
                var country = results[0].address_components[length - 1];
                var town = results[0].address_components[length - 3];

                if (where == "s") {
                    document.getElementById(lat).value = town.long_name;
                    document.getElementById(long).value = country.short_name;
                } else {
                    document.getElementById(lat).value = latitude;
                    document.getElementById(long).value = longitude;
                    document.getElementById(addr).value = address;
                }
            } else {
                showErrorMessage("locate_user", status);
            }
        });
    }, function () {
        showErrorMessage("locate_user", 'Unable to fetch location');
    });
}

function initMapUser() {

    var latitude = parseFloat($("#hd-message-latitude").val());
    var longitude = parseFloat($("#hd-message-longitude").val());
    var address = $("#hd-message-address").val();
    var myLatLng = {
        lat: latitude,
        lng: longitude
    };

    map = new google.maps.Map(document.getElementById('hd-message-map'), {
        zoom: 16,
        center: myLatLng,
        gestureHandling: 'cooperative'
    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: address
    });

    markers.push(marker);

    var geocoder = new google.maps.Geocoder();

    google.maps.event.addListener(map, 'click', function (event) {
        geocoder.geocode({
            'latLng': event.latLng
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var n_address = results[0].formatted_address;
                    var n_latitude = results[0].geometry.location.lat();
                    var n_longitude = results[0].geometry.location.lng();
                    var position = {
                        lat: n_latitude,
                        lng: n_longitude
                    }

                    $("#hd-message-latitude").val(n_latitude);
                    $("#hd-message-longitude").val(n_longitude);
                    $("#hd-message-address").val(n_address);

                    clearMarkers();

                    var marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: n_address
                    });
                    markers.push(marker);
                }
            } else {
                showErrorMessage("init_map", status);
            }
        });
    });
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

function clearMarkers() {
    setMapOnAll(null);
}

function deleteMarkers() {
    clearMarkers();
    markers = [];
}

function InitializePlaces(input) {
    var autocomplete = new google.maps.places.Autocomplete(document.getElementById(input));
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        autocomplete.getPlace();
    });
}

function loadMapMessage(container, address, longitude, latitude, zoom = 14) {
    var myLatLng = {
        lat: parseFloat(latitude),
        lng: parseFloat(longitude)
    };
    var map = new google.maps.Map(document.getElementById(container), {
        zoom: zoom,
        center: myLatLng,
        gestureHandling: 'cooperative'
    });
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: address
    });
}

function calculateDistance(end, start) {
    return (google.maps.geometry.spherical.computeDistanceBetween(end, start) / 1000).toFixed(2);
}

function drawRouteMap(latitude, longitude, address, container, mode) {

    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;

    directionsDisplay = new google.maps.DirectionsRenderer();

    var myLatLng = {
        lat: parseFloat(latitude),
        lng: parseFloat(longitude)
    };

    map = new google.maps.Map(document.getElementById(container), {
        zoom: 17,
        center: myLatLng,
        gestureHandling: 'cooperative'
    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: address
    });

    var from_lat = parseFloat($("#latitude_else").val());
    var from_long = parseFloat($("#longitude_else").val());
    var from_address = $("#search_else").val();

    var end = new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude));
    var start = new google.maps.LatLng(from_lat, from_long);

    $("#distance").text(calculateDistance(end, start) + " km");

    var service = new google.maps.DistanceMatrixService();
    var bounds = new google.maps.LatLngBounds();

    bounds.extend(start);
    bounds.extend(end);
    map.fitBounds(bounds);

    if (mode == "d") {
        service.getDistanceMatrix({
            origins: [from_address],
            destinations: [address],
            travelMode: 'DRIVING',
            drivingOptions: {
                departureTime: new Date(Date.now()),
                trafficModel: 'optimistic'
            },
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: true,
            avoidTolls: true,

        }, function (response) {
            var time_drive = response.rows[0].elements[0].duration.text;
            var time_with_traffic = response.rows[0].elements[0].duration_in_traffic.text;
            var distance = response.rows[0].elements[0].distance.text;
            $("#time").text(time_drive);
            $("#with_traffic").show();
            $("#time_drive_traffic").text(time_with_traffic + " (with traffic)");
            $("#distance").text(distance);
        });

        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING
        };

        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);
            } else {
                showErrorMessage("draw_routes", status);
            }
        });

    } else if (mode == "w") {
        service.getDistanceMatrix({
            origins: [from_address],
            destinations: [address],
            travelMode: 'WALKING',
            drivingOptions: {
                departureTime: new Date(Date.now()),
                trafficModel: 'optimistic'
            },
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: true,
            avoidTolls: true,

        }, function (response) {
            var time_walk = response.rows[0].elements[0].duration.text;
            var distance = response.rows[0].elements[0].distance.text;
            $("#time").text(time_walk);
            $("#distance").text(distance);
            $("#with_traffic").hide();
        });

        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.WALKING
        };

        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);
            } else {
                showErrorMessage("draw_routes", status);
            }
        });

    } else {
        showErrorMessage("draw_routes", `Unknown Mode ${mode}`);
    }
}