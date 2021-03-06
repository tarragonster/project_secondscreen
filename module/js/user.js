var User = /** @class */ (function () {
    function User() {
        this.typereq = 'get';
        this.isEdit = false;
        this.isProfile = true;
        this.isCreate = false;
        this.active = 'profile';
        this.switch = false;
        this.contentType = false;
        this.processData = true;
    }
    User.prototype.sendAjaxRequest = function (_callback) {
        $.ajax({
            type: this.typereq,
            dataType: 'json',
            url: this.url,
            data: this.paramreq,
            headers: this.paramheader,
            success: function (data) {
                _callback(data);
            },
        });
    };
    User.prototype.sendAjaxFormData = function (_callback) {
        $.ajax({
            type: this.typereq,
            dataType: 'json',
            url: this.url,
            data: this.paramreq,
            enctype: 'multipart/form-data',
            headers: this.paramheader,
            success: function (data) {
                _callback(data);
            },
            contentType: this.contentType,
            processData: this.processData,
        });
    };
    User.prototype.showUserProfile = function () {
        // $('#view-user-content').html("");
        this.paramreq = {
            user_id: this.user_id,
            isEdit: this.isEdit,
            isProfile: this.isProfile,
            isCreate: this.isCreate,
            active: this.active,
        };
        this.url = '/user/ajaxProfile/' + this.user_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            model.isProfile = true;
            model.isEdit = false;
            model.isCreate = false;
            $('#view-user-content').html(data.content);
        });
    };
    User.prototype.showCommentUser = function () {
        this.paramreq = {
            user_id: this.user_id,
            isEdit: this.isEdit,
            isProfile: this.isProfile,
            isCreate: this.isCreate,
            active: this.active,
        };
        this.url = '/user/ajaxProfile/' + this.user_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            model.isProfile = true;
            model.isEdit = false;
            model.isCreate = false;
            $('#view-replies-content').html(data.content);
        });
    };
    User.prototype.saveUpdateProfile = function (myFormData) {
        this.paramreq = myFormData;
        this.url = '/user/ajaxEdit/' + this.user_id;
        this.typereq = 'POST';
        this.sendAjaxFormData(function (data) {
            if (data.user_message != null || data.email_message != null) {
                $('.email-smg').text(data.email_message);
                $('.user-smg').text(data.user_message);
            }
            else {
                model.showUserProfile();
            }
        });
    };
    User.prototype.showEditPick = function () {
        this.url = '/user/editPick/' + this.pick_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#edit-pick-content').html(data.content);
        });
    };
    User.prototype.saveEditPick = function () {
        this.url = '/user/editPick/' + this.pick_id;
        this.typereq = 'POST';
        this.paramreq = {
            quote: this.quote
        };
        this.sendAjaxRequest(function (data) {
            model.active = 'your-picks';
            model.showUserProfile();
            model.active = 'profile';
        });
    };
    User.prototype.deletePick = function () {
        this.url = '/user/removePick/' + this.pick_id;
        this.typereq = 'POST';
        this.paramreq = {
            confirmDelete: this.confirmDelete
        };
        this.sendAjaxRequest(function (data) {
            $('.msg-toDelete').text(data.message);
            model.active = 'your-picks';
            model.showUserProfile();
            model.active = 'profile';
            ToClosePickModal();
        });
    };
    User.prototype.confirmDeleteWatch = function () {
        this.url = '/user/removeWatch/' + this.watch_id;
        this.typereq = 'POST';
        this.paramreq = {
            confirmDelete: this.confirmDelete
        };
        this.sendAjaxRequest(function (data) {
            $('.msg-toDelete-watch').text(data.message);
            model.active = 'watch-list';
            model.showUserProfile();
            model.active = 'profile';
            ToCloseWatchModal();
        });
    };
    User.prototype.saveBlockUser = function () {
        this.url = '/user/block/' + this.user_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    User.prototype.saveUnblockUser = function () {
        this.url = '/user/unblock/' + this.user_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    User.prototype.showFirstDeleteModal = function () {
        this.url = '/user/firstModalDelete';
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#delete-user-content').html(data.content);
        });
    };
    User.prototype.showSecondDeleteModal = function () {
        this.url = '/user/secondModalDelete';
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#delete-user-content').html(data.content);
        });
    };
    User.prototype.confirmDeleteUser = function () {
        this.url = '/user/delete/' + this.user_id;
        this.typereq = 'POST';
        this.paramreq = {
            confirmDelete: this.confirmDelete
        };
        this.sendAjaxRequest(function (data) {
            $('.msg-toDelete-user').text(data.message);
            ToCloseUserModal();
        });
    };
    User.prototype.showReportNote = function () {
        this.url = '/user/showNote/' + this.report_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#view-note-content').html(data.content);
        });
    };
    User.prototype.saveReportNote = function () {
        this.url = '/user/saveNote/' + this.report_id;
        this.typereq = 'POST';
        this.paramreq = {
            note: this.note
        };
        this.sendAjaxRequest(function (data) {
            $('#view-note-content').html(data.confirmContent);
            model.switch = true;
        });
    };
    User.prototype.editReportNote = function () {
        this.url = '/user/editNote/' + this.report_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#view-note-content').html(data.content);
        });
    };
    User.prototype.showConfirmNote = function () {
        this.url = '/user/confirmNote/' + this.report_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#view-note-content').html(data.content);
        });
    };
    User.prototype.removeComment = function () {
        this.url = '/user/deleteComment/' + this.comment_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            model.active = 'comments';
            model.showUserProfile();
            model.active = 'profile';
            $('#delete-comment').modal('hide');
        });
    };
    User.prototype.showCommentReplies = function () {
        this.url = '/user/ShowCommentReplies/' + this.comment_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            if (location.pathname.split('/')[1] == 'user' || location.pathname.split('/')[1] == 'explore') {
                $('#view-user-content').html('');
                $('#view-user-content').html(data.content);
            }
            if (location.pathname.split('/')[1] == 'comment') {
                $('#view-replies-content').html('');
                $('#view-replies-content').html(data.content);
            }
        });
    };
    User.prototype.saveDisableUserReported = function () {
        this.url = '/user/disableUserReported/' + this.user_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    User.prototype.saveEnableUserReported = function () {
        this.url = '/user/enableUserReported/' + this.user_id + '/' + this.report_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    User.prototype.saveRemoveReport = function () {
        this.url = '/user/saveRemoveReport/' + this.report_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    User.prototype.showFirstDeleteReported = function () {
        this.url = '/user/firstModalDeleteReported';
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#delete-user-content').html(data.content);
        });
    };
    User.prototype.showSecondDeleteReported = function () {
        this.url = '/user/showSecondDeleteReported';
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#delete-user-content').html(data.content);
        });
    };
    User.prototype.confirmDeleteReported = function () {
        this.url = '/user/deleteReported/' + this.user_id;
        this.typereq = 'POST';
        this.paramreq = {
            confirmDelete: this.confirmDelete
        };
        this.sendAjaxRequest(function (data) {
            $('.msg-toDelete-user').text(data.message);
            ToCloseUserModal();
        });
    };
    User.prototype.addVerify = function () {
        this.url = '/user/addVerify/' + this.user_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    User.prototype.addCurator = function () {
        this.url = '/user/addCurator/' + this.user_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    User.prototype.removeTag = function () {
        this.url = '/user/removeTag/' + this.user_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    User.prototype.confirmDeleteEpisodeLike = function () {
        this.url = '/user/deleteEpisodeLike/' + this.episodeLike_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            model.switch = true;
            model.active = 'thumb-up';
            model.showUserProfile();
            model.active = 'profile';
            $('#delete-episode-like').modal('hide');
        });
    };
    User.prototype.confirmDeleteProductLike = function () {
        this.url = '/user/deleteProductLike/' + this.productLike_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            model.switch = true;
            model.active = 'thumb-up';
            model.showUserProfile();
            model.active = 'profile';
            $('#delete-product-like').modal('hide');
        });
    };
    User.prototype.confirmDeleteCommentLike = function () {
        this.url = '/user/deleteCommentLike/' + this.commentLike_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            model.switch = true;
            model.active = 'thumb-up';
            model.showUserProfile();
            model.active = 'profile';
            $('#delete-comment-like').modal('hide');
        });
    };
    User.prototype.showCommentList = function () {
        this.url = '/user/showCommentList/' + this.ep_id + '/' + this.comment_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            window.location.replace('/comment/comments/' + model.ep_id + '/' + data.page);
        });
    };
    User.object = new User();
    return User;
}());
var model = User.object;
function ShowUserProfile(event) {
    model.isProfile = true;
    model.isEdit = false;
    model.user_id = $(event).data('user_id') * 1;
    model.showUserProfile();
    $('#view-user-popup').modal('show');
}
function EditUserProfile(event) {
    console.log('aaa');
    model.isProfile = false;
    model.isEdit = true;
    if (location.pathname.split('/')[1] == 'user' || location.pathname.split('/')[1] == 'explore') {
        model.showUserProfile();
    }
    if (location.pathname.split('/')[1] == 'comment') {
        model.showCommentUser();
    }
    model.isEdit = false;
    model.isProfile = true;
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        $('.the-avatar').attr('src', "");
        reader.onload = function (e) {
            $('.the-avatar')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function SaveUpdateProfile() {
    //form-update
    console.log('SaveUpdateProfile');
    $("#form-update").validate({
        rules: {
            full_name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            user_name: {
                required: true,
            },
            bio: {
                required: true,
            },
            avatar: {
                filesize: 1000000,
            }
        },
        messages: {
            email: {
                required: "Email is invalid",
                email: "Your email address must be in the format of name@domain.com"
            }
        }
    });
    var validatedata = $("#form-update").valid();
    if (validatedata == true) {
        model.contentType = false;
        model.processData = false;
        var myformData = new FormData();
        myformData.append('full_name', $('input[name=full_name]').val());
        myformData.append('user_name', $('input[name=user_name]').val());
        myformData.append('email', $('input[name=email]').val());
        myformData.append('bio', $('.bio-input').text());
        myformData.append('avatar', $('input[name=avatar]')[0].files[0]);
        if ($('.check-feature').is(":checked")) {
            myformData.append('feature', '1');
        }
        else {
            myformData.append('feature', '0');
        }
        if ($('.check-curator').is(":checked")) {
            myformData.append('curator', '2');
        }
        else {
            myformData.append('curator', '0');
        }
        model.saveUpdateProfile(myformData);
        model.switch = true;
    }
}
$('#view-user-popup').on('hidden.bs.modal', function () {
    if (model.switch == true) {
        location.reload();
        model.switch = false;
    }
});
$('#view-note-popup').on('hidden.bs.modal', function () {
    if (model.switch == true) {
        location.reload();
        model.switch = false;
    }
});
function ShowEditPick(event) {
    model.pick_id = $(event).data('pick_id');
    model.showEditPick();
    $('#edit-pick-view').modal('show');
}
function SaveEditPick() {
    model.quote = $('.quote-input').text();
    model.saveEditPick();
    $('#edit-pick-view').modal('hide');
}
function DeleteShow(event) {
    model.pick_id = $(event).data('pick_id');
    $('.msg-toDelete').text(' ');
    $('.text-diff').text('delete');
    $('#delete-view').modal('show');
    $('#input-confirm-delete').val('');
}
function ConfirmDeletePick() {
    model.confirmDelete = $('#input-confirm-delete').val();
    model.deletePick();
}
function ToClosePickModal() {
    if ($('.msg-toDelete').text().trim() == '') {
        $('#delete-view').modal('hide');
        model.switch = true;
    }
}
function DeleteShowWatch(event) {
    model.watch_id = $(event).data('watch_id');
    $('.msg-toDelete-watch').text(' ');
    $('.text-diff').text('remove');
    $('#delete-view-watch').modal('show');
    $('#watch-confirm-delete').val('');
}
function ConfirmDeleteWatch() {
    model.confirmDelete = $('#watch-confirm-delete').val();
    console.log(model.confirmDelete);
    model.confirmDeleteWatch();
}
function ToCloseWatchModal() {
    if ($('.msg-toDelete-watch').text().trim() == '') {
        $('#delete-view-watch').modal('hide');
        model.switch = true;
    }
}
function ShowBlockUser(event) {
    model.user_id = $(event).data('user_id');
    $('#disable-view').modal('show');
}
function SaveBlockUser() {
    model.saveBlockUser();
}
function ShowUnblockUser(event) {
    model.user_id = $(event).data('user_id');
    $('#enable-view').modal('show');
}
function SaveUnblockUser() {
    model.saveUnblockUser();
}
function ShowFirstDeleteModal(event) {
    model.user_id = $(event).data('user_id');
    model.showFirstDeleteModal();
    $('#delete-user').modal('show');
}
function ShowSecondDeleteModal() {
    model.showSecondDeleteModal();
}
function ConfirmDeleteUser() {
    model.confirmDelete = $('#user-confirm-delete').val();
    model.confirmDeleteUser();
}
function ToCloseUserModal() {
    if ($('.msg-toDelete-user').text().trim() == '') {
        location.reload();
    }
}
// report modal
function ShowReportNote(event) {
    model.report_id = $(event).data('report_id');
    model.showReportNote();
    $('#view-note-popup').modal('show');
}
function SaveReportNote() {
    $("#form-user-update").validate({
        rules: {
            note: {
                required: true,
            },
        },
        messages: {}
    });
    var validatedata = $("#form-user-update").valid();
    if (validatedata == true) {
        model.note = $('.note-input').text();
        model.saveReportNote();
    }
}
function EditReportNote() {
    model.editReportNote();
}
$(document).ready(function () {
    $(document).on('show.bs.modal', '.modal', function (event) {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
});
function ShowRemoveComment(event) {
    model.comment_id = $(event).data('comment_id');
    $('#delete-comment').modal('show');
}
function RemoveComment() {
    model.removeComment();
    model.switch = true;
}
function ShowCommentReplies(event) {
    model.comment_id = $(event).data('comment_id');
    model.showCommentReplies();
}
function BackComments(event) {
    model.comment_id = $(event).data('comment_id');
    model.active = 'comments';
    if (location.pathname.split('/')[1] == 'user' || location.pathname.split('/')[1] == 'explore') {
        model.showUserProfile();
    }
    if (location.pathname.split('/')[1] == 'comment') {
        model.showCommentUser();
    }
    model.active = 'profile';
}
function ShowTabProfile() {
    if (location.pathname.split('/')[1] == 'user' || location.pathname.split('/')[1] == 'explore') {
        model.showUserProfile();
    }
    if (location.pathname.split('/')[1] == 'comment') {
        model.showCommentUser();
    }
}
function ShowTabComment() {
    model.isProfile = false;
    model.isEdit = false;
    model.isCreate = false;
    model.active = 'comments';
    if (location.pathname.split('/')[1] == 'user' || location.pathname.split('/')[1] == 'explore') {
        model.showUserProfile();
    }
    if (location.pathname.split('/')[1] == 'comment') {
        model.showCommentUser();
    }
    model.active = 'profile';
}
function ShowTabPick() {
    model.isProfile = false;
    model.isEdit = false;
    model.isCreate = false;
    model.active = 'your-picks';
    if (location.pathname.split('/')[1] == 'user' || location.pathname.split('/')[1] == 'explore') {
        model.showUserProfile();
    }
    if (location.pathname.split('/')[1] == 'comment') {
        model.showCommentUser();
    }
    model.active = 'profile';
}
function ShowTabWatch() {
    model.isProfile = false;
    model.isEdit = false;
    model.isCreate = false;
    model.active = 'watch-list';
    if (location.pathname.split('/')[1] == 'user' || location.pathname.split('/')[1] == 'explore') {
        model.showUserProfile();
    }
    if (location.pathname.split('/')[1] == 'comment') {
        model.showCommentUser();
    }
    model.active = 'profile';
}
function ShowTabThumbsup() {
    model.isProfile = false;
    model.isEdit = false;
    model.isCreate = false;
    model.active = 'thumb-up';
    if (location.pathname.split('/')[1] == 'user' || location.pathname.split('/')[1] == 'explore') {
        model.showUserProfile();
    }
    if (location.pathname.split('/')[1] == 'comment') {
        model.showCommentUser();
    }
    model.active = 'profile';
}
function ShowDisableUserReported(event) {
    model.user_id = $(event).data('user_id');
    $('#disable-user-reported').modal('show');
}
function SaveDisableUserReported() {
    model.saveDisableUserReported();
}
function ShowEnableUserReported(event) {
    model.user_id = $(event).data('user_id');
    model.report_id = $(event).data('report_id');
    $('#enable-user-reported').modal('show');
}
function SaveEnableUserReported() {
    model.saveEnableUserReported();
}
function ShowRemoveReport(event) {
    model.report_id = $(event).data('report_id');
    $('#remove-reported').modal('show');
}
function SaveRemoveReport() {
    model.saveRemoveReport();
}
function ShowFirstDeleteReported(event) {
    model.user_id = $(event).data('user_id');
    model.showFirstDeleteReported();
    $('#delete-user').modal('show');
}
function ShowSecondDeleteReported(event) {
    model.showSecondDeleteReported();
}
function ConfirmDeleteReported() {
    model.confirmDelete = $('#user-confirm-delete').val();
    model.confirmDeleteReported();
}
function FillInput(event) {
    var divfield = $(event).text();
    $("[name=bio]").val(divfield);
}
function FillNote(event) {
    var divfield = $(event).text();
    $("[name=note]").val(divfield);
}
$(document).ready(function () {
    $.validator.setDefaults({
        ignore: []
    });
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    }, 'File size must be less than 1MB');
    $.validator.addMethod("confirmInput", function (value, element) {
        if (this.optional(element) || value == "REMOVE") {
            return true;
        }
        else {
            return false;
        }
    }, 'Sorry, it must be confirmed by typing "REMOVE" into input box above');
});
function ShowEditNote(event) {
    model.report_id = $(event).data('report_id');
    $('#view-note-popup').modal('show');
    model.editReportNote();
}
function ShowConfirmNote(event) {
    model.report_id = $(event).data('report_id');
    $('#view-note-popup').modal('show');
    model.showConfirmNote();
}
function AddVerify(event) {
    model.user_id = $(event).data('user_id');
    model.addVerify();
}
function AddCurator(event) {
    model.user_id = $(event).data('user_id');
    model.addCurator();
}
function RemoveTag(event) {
    model.user_id = $(event).data('user_id');
    model.removeTag();
}
function showDeleteEpisodeLike(event) {
    model.episodeLike_id = $(event).data('el_id');
    $('#delete-episode-like').modal('show');
}
function ConfirmDeleteEpisodeLike() {
    $('#form-episodeLike-delete').validate({
        rules: {
            confirmDelete: {
                required: true,
                confirmInput: true
            },
        },
    });
    var validatedata = $("#form-episodeLike-delete").valid();
    if (validatedata == true) {
        model.confirmDeleteEpisodeLike();
    }
}
function ShowDeleteProductLike(event) {
    model.productLike_id = $(event).data('pl_id');
    $('#delete-product-like').modal('show');
}
function ConfirmDeleteProductLike() {
    $('#form-productLike-delete').validate({
        rules: {
            confirmDeletePL: {
                required: true,
                confirmInput: true
            },
        },
    });
    var validatedata = $("#form-productLike-delete").valid();
    if (validatedata == true) {
        model.confirmDeleteProductLike();
    }
}
function ShowDeleteCommentLike(event) {
    model.commentLike_id = $(event).data('cl_id');
    $('#delete-comment-like').modal('show');
}
function ConfirmDeleteCommentLike() {
    $('#form-commentLike-delete').validate({
        rules: {
            confirmDeleteCL: {
                required: true,
                confirmInput: true
            },
        },
    });
    var validatedata = $("#form-commentLike-delete").valid();
    if (validatedata == true) {
        model.confirmDeleteCommentLike();
    }
}
function ShowCommentUser(event) {
    model.isProfile = true;
    model.isEdit = false;
    model.user_id = $(event).data('user_id');
    model.showCommentUser();
    $('#view-replies-popup').modal('show');
}
function ShowReportedCommentUser(event) {
    model.isProfile = true;
    model.isEdit = false;
    model.user_id = $(event).data('user_id');
    model.showCommentUser();
    $('#view-replies-popup').modal('show');
}
function ShowCommentList(event) {
    model.ep_id = $(event).data('ep_id');
    model.showCommentList();
}
