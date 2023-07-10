jQuery(($) => {

    // show html form 
    $(document).on("click", ".login-user-button", () => {

        $.getJSON("http://blog/src/users/read.php", (data) => {
            //get data
        });
        
        return false;
    });
});