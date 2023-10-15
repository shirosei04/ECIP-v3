/*!
    * Start Bootstrap - SB Admin v7.0.4 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2021 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    //
// Scripts
//


window.addEventListener("load", () => {
    const loader = document.querySelector(".loader");

    loader.classList.add("loader-hidden");

    loader.addEventListener("transitioned", () => {
        document.body.removeChild("loader");
    })
});


window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

// REGISTER BUTTON
var checkerOne = document.getElementById('checkOne');
var regbtn = document.getElementById('regBtn');
regbtn.disabled = true;
checkerOne.onchange = function() {
        if(this.checked){
            regbtn.disabled = false;
        } else {
            regbtn.disabled = true;
        }
    }






   //username auto creation
function getValue(){
    //get fname value
    let fname = document.getElementById("firstname");
    let fnameValue = fname.value;
    //get lname value
    let lname = document.getElementById("lastname");
    let lnameValue = lname.value;

    //only take first name
    let onlyFirst = fnameValue.split(" ")[0]

    //concatenate fname & lname value and save it in a var
    let fusername = lnameValue.concat("_"+onlyFirst).toLowerCase();

    //set disabled textbox's value for display
    document.getElementById('username').value = fusername;
    //set hidden textbox's value to save in DB
    document.getElementById('susername').value = fusername;
}


