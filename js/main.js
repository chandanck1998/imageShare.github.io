/* contact form code start */
$(document).ready(function(){
    $("#contactForm").submit(function(e){
        e.preventDefault();
        alert("massage sent");
    });
});

/* check login start */
$(document).ready(function(){
    $("#uploadBtn").click(function(){
        var response = checkUser("loginCheck");
        return false;
    });
});

function checkUser(task){
    $.ajax({
        type:"get",
        url:"php/checkUser.php",
        data:{
            task:task,
        },
        success:function(response){
           data = JSON.parse(response);
           if(data.data=="userFound")
           {
               $("#uplodaImage").modal({
                   show:true,
                   backdrop:"static",
                   keyboard:false,
               });
               showGroups("group");
           }
           else{
                alert("no login found");
           }
        },
    });
}
/* check login end */

/* create group ajax start */
$(document).ready(function(){
    $("#createGroup").submit(function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            url:"php/group.php",
            data:new FormData(this),
            processData:false,
            contentType:false,
            success:function(response){
                if(response=="success")
                {
                    showGroups("group");
                    showGroups("menu");

                    $(".groupAlert").html(`
                        <div class="alert alert-success p-2 d-flex mt-3"><span class="material-icons">check</span> Group Created!</div>
                    `);
                    setTimeout(function(){
                        $(".groupAlert").html("");
                        $("#createGroup")[0].reset();
                    },2000);
                }
                if(response=="failed")
                {
                    $(".groupAlert").html(`
                        <div class="alert alert-warning p-2 d-flex mt-3"><span class="material-icons">warning</span> Opps! somthing wrong.</div>
                    `);
                    setTimeout(function(){
                        $(".groupAlert").html("");
                        $("#createGroup")[0].reset();
                    },2000);
                }
            },
        });
    });
});

$(document).ready(function(){
    showGroups("menu");
});

function showGroups(task){
    $("#uGroup").html(`<option value=" ">Select Group</option>`);
    $.ajax({
        type:"GET",
        url:"php/group.php",
        success:function(response){
            if(task=="menu")
            {
                createMenu(response);
            }
            if(response.trim()!=="")
            {
                if(task=="group")
                {
                    addGroup(response);
                }
            }
        },
    });
}

/* create menus of group or tag */
function createMenu(response){
    if(response.trim()!=="")
    {
        $(".tagBar ul").html("<li><button tag='all'>all</button></li>");
        var data = JSON.parse(response);
        data.forEach(function(data){
            var btns = document.createElement("BUTTON");
            btns.innerHTML = data.imageTag;
            btns.setAttribute("tag",data.imageTag);
            var lis = document.createElement("LI");
            lis.append(btns);
            $(".tagBar ul").append(lis);
        });
    }
    else{
        $(".tagBar ul").html("<li><button tag='all'>all</button></li>");
    }
}

/* showing group on upload form */
function addGroup(response)
{
    var data = JSON.parse(response);
    data.forEach(function(data){
        var opt = document.createElement("OPTION");
        opt.innerHTML = data.imageTag;
        opt.value = data.imageTag;
        $("#uGroup").append(opt);
    });
}
/* create group ajax end */



/* upload image code start */
$(document).ready(function(){
    $("#uImage").on("change",function(){
        var file = this.files[0];
        var imgName = file.name.split(".")[0];
        var url = URL.createObjectURL(file);
        var image = new Image();
        image.src= url;
        image.onload=function(){
            $(".imagePreview").html(image);
            if($("#uImageName").val()=="")
            {
                $("#uImageName").val(imgName);
            }
        }
    });

    $("#uploadForm").submit(function(e){
        e.preventDefault();
        
        // empty validation
        $(".required").each(function(){
            if(this.value.trim() == "")
            {
                $(this).addClass("border-danger text-danger animate__animated animate__shakeX emptyForm");

                $(this).on("focus",function(){
                    $(this).removeClass("border-danger text-danger animate__animated animate__shakeX emptyForm");
                });
            }
        });

        if(document.getElementsByClassName("emptyForm").length==0)
        {
            $.ajax({
                type:"POST",
                url:"php/upload.php",
                data:new FormData(this),
                processData:false,
                contentType:false,
                beforeSend:function()
                {
                    $(".uLoader").removeClass("d-none");
                    $(".uploadBtn").attr("type","button");
                },
                success:function(response){
                    $(".uLoader").addClass("d-none");
                    $(".uploadBtn").attr("type","submit");

                    if(response.trim() != "")
                    {
                        if(response=="success")
                        {
                            $(".ualert").html('<div class="alert alert-success d-flex"><span class="material-icons ml-1">check</span> Success!</div>');
                            setTimeout(function(){
                                $(".imagePreview").html("");
                                $(".ualert").html("");
                                $("#uploadForm")[0].reset();
                            },2000);
                        }
                        if(response=="fileExist")
                        {
                            $(".ualert").html('<div class="alert alert-warning d-flex"><span class="material-icons ml-1">warning</span> file exist! use unique name.</div>');
                            setTimeout(function(){
                                $(".ualert").html("");
                                $("#uImageName").val("");
                            },2000);
                            $
                        }
                        if(response=="failed")
                        {
                            $(".ualert").html('<div class="alert alert-danger d-flex"><span class="material-icons ml-1">close</span> Opps! something wrong.</div>');
                            setTimeout(function(){
                                $(".ualert").html("");
                                $(".imagePreview").html("");
                                $("#uploadForm")[0].reset();
                            },2000);
                        }
                    }
                },
            });
        }
        
    });
});
/* upload image code end */



/* Get Images and show start */
$(document).ready(function(){
    getImages("all");
});

/* get */
function getImages(data){
    $.ajax({
        type:"GET",
        url:"php/upload.php",
        data:{
            fetch:data,
        },
        success:function(response){
            if(response!=="" && response!=="empty")
            {
                showImages(response);
            }
            else{
                $(".imageCon").append(`
                    <div class="text-center mt-5">
                        <h2>Empty!</h2>
                        <p>Sorry! there is no image yet, but you can upload your won images.</p>
                    </div>
                `);
            }
        }
    });
}

/* show */
function showImages(response){
    response = JSON.parse(response);
    response.forEach(function(data,index){
        template = `
            <div class="col-md-3">
                <div class="imgBox imgBox`+index+`">
                    <div class="image"></div>
                    <div class="imgTitle"></div>
                </div>
            </div>
        `;
        var url = data.images;
        var image = new Image();
        image.src = url;
        image.onload=function(){
            $(".imgBox"+index+" .image").html(image);
        }

        $(".imageCon .row").append(template);
    });
}
/* Get Images and show end */

/* user signup code start */
$(document).ready(function(){
    $("#logModal").modal({
        show:true,
        backdrop:"static",
        keyboard:false,
    });
    $(".loginBtn").click(function(){
        $("#logModal").modal({
            show:true,
            backdrop:"static",
            keyboard:false,
        });
    });

    $(".showSignPass").click(function(){
        if($(this).attr("status")==0)
        {
            $("#sPass").attr("type","text");
            $(this).html("visibility_off");
            $(this).attr("status",1)
        }
        else{
            $("#sPass").attr("type","password");
            $(this).html("visibility");
            $(this).attr("status",0)
        }
    });

    $(".showLogPass").click(function(){
        if($(this).attr("status")==0)
        {
            $("#lPass").attr("type","text");
            $(this).html("visibility_off");
            $(this).attr("status",1)
        }
        else{
            $("#lPass").attr("type","password");
            $(this).html("visibility");
            $(this).attr("status",0)
        }
    });
});

$(document).ready(function(){
    $(".tabBtns button").each(function(){
        $(this).click(function(){
            $(".tabBtns button").removeClass("active");
            $(this).addClass("active");
            if($(this).attr("data")=="login")
            {
                $(".loginCon").removeClass("d-none");
                $(".signCon").addClass("d-none");
            }
            else{
                $(".loginCon").addClass("d-none");
                $(".signCon").removeClass("d-none");
            }
        });
    });
});

$(document).ready(function(){
    $("#signForm").submit(function(e){
        e.preventDefault();

        $("#signForm .required").each(function(){
            if(this.value.trim() == "")
            {
                $(this).addClass("border-danger text-danger animate__animated animate__shakeX emptyForm");

                $(this).on("focus",function(){
                    $(this).removeClass("border-danger text-danger animate__animated animate__shakeX emptyForm");
                });
            }
        });

        if(this.getElementsByClassName("emptyForm").length==0)
        {
            $.ajax({
                type:"post",
                url:"php/users.php",
                data:new FormData(this),
                processData:false,
                contentType:false,
                success:function(response)
                {
                    if(response.trim()!=="")
                    {
                        if(response=="success")
                        {
                            $(".signAlert").html('<div class="alert alert-success d-flex"><span class="material-icons ml-1">check</span> Success!</div>');
                            setTimeout(function(){
                                $(".signAlert").html("");
                                $("#signForm")[0].reset();
                                $(".loginTabBtn").click();
                            },2000);
                        }
                        if(response=="failed")
                        {
                            $(".signAlert").html('<div class="alert alert-danger d-flex"><span class="material-icons ml-1">close</span> Opps! something wrong.</div>');
                            setTimeout(function(){
                                $(".signAlert").html("");
                                $("#signForm")[0].reset();
                            },2000);
                        }
                    }
                }
            });
        }
    });
});

//login start
$(document).ready(function(){
    $("#loginForm").submit(function(e){
        e.preventDefault();

        $("#loginForm .required").each(function(){
            if(this.value.trim() == "")
            {
                $(this).addClass("border-danger text-danger animate__animated animate__shakeX emptyForm");

                $(this).on("focus",function(){
                    $(this).removeClass("border-danger text-danger animate__animated animate__shakeX emptyForm");
                });
            }
        });

        if(this.getElementsByClassName("emptyForm").length==0)
        {
            var username = $("#lUname").val();
            var password = $("#lPass").val();
            $.ajax({
                type:"get",
                url:"php/users.php",
                data:{
                    username:username,
                    password:password
                },
                processData:false,
                contentType:false,
                success:function(response)
                {
                    console.log(response);
                }
            });
        }
    });
});