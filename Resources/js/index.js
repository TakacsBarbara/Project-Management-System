
$(document).ready( function() {

    $('#new-project-save').click( (e) => {
        const newProjectName = $('#new-project-name').val();
        const newProjectDesc = $('#new-project-description').val();
        const newProjectstatus = $('#new-project-status option:selected').text();

        
        if (newProjectName && newProjectDesc && newProjectstatus) {
            e.preventDefault();
            $.post({
                url: "../Controller/ajax.php",
                data: {
                    newProjectName: newProjectName,
                    newProjectDesc: newProjectDesc,
                    newProjectstatus: newProjectstatus,
                },
                success: function(data) {
                    $("#new-project-id").val(data);
                    $("#new-project-save").hide();
                    setResultMessage(data);
                    setTimeout(function() {
                        $("#result").hide();
                        $("#new-contact-section").show();
                        $('html, body').animate({
                            scrollTop: $("#new-contact-section").offset().top
                        }, 0);
                    }, 1000);
                }
            });
        } else {
            showRequiredInputMessage("#result");
        }
    });

    $("#add-new-contact-row").click( () => {
        let updateContactId = $("#edited-contact-id").val();
        const newContactName = $("#new-contact-name").val();
        const newContactEmail = $("#new-contact-email").val();
        const projectId = $("#new-project-id").val();

        if (newContactName && newContactEmail && projectId) {

            if (updateContactId) {
                let editedFields = $("td#"+updateContactId).siblings();
                $.post({
                    url: "../Controller/ajax.php",
                    data: {
                        newContactName: newContactName,
                        newContactEmail: newContactEmail,
                        projectId: projectId,
                        updateContactId: updateContactId
                    },
                    success: function(data) {
                        if (data) {
                            $("#new-contact-name").val("");
                            $("#new-contact-email").val("");
                            editedFields[0].innerHTML = newContactName;
                            editedFields[1].innerHTML = newContactEmail;
                            
                        }
                    }
                });
            } else {
                $.post({
                    url: "../Controller/ajax.php",
                    data: {
                        newContactName: newContactName,
                        newContactEmail: newContactEmail,
                        projectId: projectId,
                        "saveContact":"1"
                    },
                    success: function(data) {
                        if (data) {
                            $("#new-contact-name").val("");
                            $("#new-contact-email").val("");
                            $("#contact-table").append(data);
                        }
                    }
                });
            }
        } else {
            showErrorMessage();
        }

    });

    $("#project-update").click( (e) => {
        const projectId = $("#new-project-id").val();
        const updatedProjectName = $('#new-project-name').val();
        const updatedProjectDesc = $('#new-project-description').val();
        const updatedProjectstatus = $('#new-project-status option:selected').text();

        if (updatedProjectName && updatedProjectDesc && updatedProjectstatus) {
            e.preventDefault();
            $.post({
                url: "../Controller/ajax.php",
                data: {
                    updatedProjectName: updatedProjectName,
                    updatedProjectDesc: updatedProjectDesc,
                    updatedProjectstatus: updatedProjectstatus,
                    projectId: projectId,
                },
                success: function(data) {
                    setResultMessage(data);
                    setTimeout(function() {
                        $("#result").hide();
                    }, 1000);
                }
            });
        } else {
            showRequiredInputMessage("#result");
        }
    })

    $(".delete-project-btn").click((e) => {
        const selectedBtn = $(e.target);
        const deletedProjectId = selectedBtn.attr('value');
        const actRow = selectedBtn.parents("tr");

        $.confirm({
            'title'     : 'Projekt törlése',
            'content'   : 'Biztosan törli a projektet?',
            'buttons'   : {
                'Igen'   : {
                    'action': function(){
                        $.post({
                            url: "../Controller/ajax.php",
                            data: {deletedProjectId: deletedProjectId},
                            success: function(data) {
                                if (data) {
                                    actRow.hide();
                                }
                            }
                        });
                    }
                },
                'Nem'    : {}
            }
        });
    });

    document.addEventListener('click',(e) =>
  {
    let elementClass = e.target.className;

    if (elementClass.includes("delete-contact")) {
        const selectedBtn = $(e.target);
        const deletedContactId = selectedBtn.attr('value');
        const actRow = selectedBtn.parents("tr");


        $.confirm({
            'title'     : 'Kapcsolattartó törlése',
            'content'   : 'Biztosan törli a kapcsolattartót?',
            'buttons'   : {
                'Igen'   : {
                    'action': function(){
                        $.post({
                            url: "../Controller/ajax.php",
                            data: {deletedContactId: deletedContactId},
                            success: function(data) {
                                if (data) {
                                    actRow.hide();
                                }
                            }
                        });
                    }
                },
                'Nem'    : {}
            }
        });
    }
  }
);

document.addEventListener('click',(e) =>
  {
    let elementClass = e.target.className;

    if (elementClass.includes(" update-contact")) {
        const selectedBtn = $(e.target);
        const updatedContactId = selectedBtn.parent().attr("id");
        const tds = selectedBtn.parent().siblings();
        let updateName = tds[0].innerText;
        let updateEmail = tds[1].innerText;

        $("#new-contact-name").val(updateName);
        $("#new-contact-email").val(updateEmail);
        $("#edited-contact-id").val(updatedContactId);

    }
  }
);

    function setSuccessStyle() {
        $("#result").removeClass("alert-danger").addClass("alert-success");
        $("#result .fas, #result p").css("color", "#0a9b0f");
        $("#result").css("display", "block");
    }

    function setFailedStyle(div) {
        $(div).removeClass("alert-success").addClass("alert-danger");
        $(div).css("display", "block");
    }
    
    function setResultMessage(data) {
        if (data == -1) {
            $("#result").html("<p>Sikertelen mentés!</p>"); 
            setFailedStyle();
        } else if (data) {
            $("#result").html("<p>Sikeres mentés!</p>"); 
            setSuccessStyle();
        }
    }

    function showRequiredInputMessage() {
        $("#result").html("<p>Mezők kitöltése kötelező!</p>"); 
        setFailedStyle("#result");
    }

    function showErrorMessage() {
        $("#error-message").html("<p>Név és email cím kitöltése kötelező!</p>"); 
        setFailedStyle("#error-message");
    }

    function refresh(){
        window.location.replace("./../View/projectList.php");
    }
});