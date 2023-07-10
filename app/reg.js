jQuery(($) => {

    // show html form 
    $(document).on("click", ".create-user-button", () => {

        $.getJSON("http://blog/src/users/create.php", (data) => {
        
            let user_html=`<select name="username" class="form-control">`;

            $.each(data.records, (key, val) => {
                categories_options_html+=`<option value="` + val.username + `">` + val.username + `</option>`;
            });

            user_html += `</select>`;

            let create_user_html=`

    <div id="read-products" class="btn btn-primary pull-right m-b-15px read-products-button">
        <span class=""></span>
    </div><!-- creating user form -->
    <form id="create-user-form" action="#create_user_html" method="post" border="0">
        <table class="table table-hover table-responsive table-bordered">

        </table>
    </form>`;

            $("#page-create_user").html(create_product_html);

            changePageTitle("Регистрация");
        });
    });

    $(document).on("create", "#create-user-form", function () {
    
        let form_data=JSON.stringify($(this).serializeObject());
    
        $.ajax({
            url: "http://blog/src/users/create.php",
            type : "POST",
            contentType : "application/json",
            data : form_data,
            success : result => {

                //show user
            },
            error: (xhr, resp, text) => {
                console.log(xhr, resp, text);
            }
        });
        
        return false;
    });
});