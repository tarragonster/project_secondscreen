var Comments = /** @class */ (function () {
    function Comments() {
        this.typereq = 'get';
        this.switch = false;
    }
    Comments.prototype.sendAjaxRequest = function (_callback) {
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
    Comments.prototype.saveDisableComment = function () {
        this.url = '/comment/disableComment/' + this.comment_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    Comments.prototype.saveEnableComment = function () {
        this.url = '/comment/enableComment/' + this.comment_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            location.reload();
        });
    };
    Comments.prototype.showFirstDeleteModal = function () {
        this.url = '/comment/firstModalDelete/' + this.comment_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#delete-content').html(data.content);
        });
    };
    Comments.prototype.showSecondDeleteModal = function () {
        this.url = '/comment/secondModalDelete/' + this.comment_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#delete-content').html(data.content);
        });
    };
    Comments.prototype.confirmDeleteComment = function () {
        this.url = '/comment/deleteComment/' + this.comment_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            $('#delete-comment').modal('hide');
            location.reload();
        });
    };
    Comments.prototype.showCommentReply = function () {
        this.url = '/comment/showCommentReplies/' + this.comment_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#view-replies-content').html(data.content);
        });
    };
    Comments.prototype.saveDisableCommentBox = function () {
        this.url = '/comment/disableComment/' + this.comment_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            commentModel.showCommentReply();
            $('#disable-comment-box').modal('hide');
        });
    };
    Comments.prototype.saveEnableCommentBox = function () {
        this.url = '/comment/enableComment/' + this.comment_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            commentModel.showCommentReply();
            $('#enable-comment-box').modal('hide');
        });
    };
    Comments.prototype.saveDisableReplyBox = function () {
        this.url = '/comment/disableReply/' + this.replies_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            commentModel.showCommentReply();
            $('#disable-reply-box').modal('hide');
        });
    };
    Comments.prototype.saveEnableReplyBox = function () {
        this.url = '/comment/enableReply/' + this.replies_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            commentModel.showCommentReply();
            $('#enable-reply-box').modal('hide');
        });
    };
    Comments.prototype.showFirstDeleteReply = function () {
        this.url = '/comment/showFirstDeleteReply';
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#delete-reply-content').html(data.content);
        });
    };
    Comments.prototype.showSecondDeleteReply = function () {
        this.url = '/comment/showSecondDeleteReply';
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#delete-reply-content').html(data.content);
        });
    };
    Comments.prototype.confirmDeleteReply = function () {
        this.url = '/comment/confirmDeleteReply/' + this.replies_id;
        this.typereq = 'POST';
        this.sendAjaxRequest(function (data) {
            $('#delete-reply').modal('hide');
            commentModel.showCommentReply();
        });
    };
    Comments.prototype.showNoteReportComment = function () {
        this.url = '/comment/showNote/' + this.report_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#view-replies-content').html(data.content);
        });
    };
    Comments.prototype.saveNoteReportComment = function () {
        this.url = '/comment/saveNote/' + this.report_id;
        this.typereq = 'POST';
        this.paramreq = {
            note: this.note
        };
        this.sendAjaxRequest(function (data) {
            $('#view-replies-content').html(data.confirmContent);
            commentModel.switch = true;
        });
    };
    Comments.prototype.showEditReportComment = function () {
        this.url = '/comment/editNote/' + this.report_id;
        this.typereq = 'GET';
        this.sendAjaxRequest(function (data) {
            $('#view-replies-content').html(data.content);
        });
    };
    Comments.object = new Comments();
    return Comments;
}());
var commentModel = Comments.object;
function ShowDisableComment(event) {
    commentModel.comment_id = $(event).data('comment_id');
    $('#disable-comment').modal('show');
}
function SaveDisableComment() {
    commentModel.saveDisableComment();
}
function ShowEnableComment(event) {
    commentModel.comment_id = $(event).data('comment_id');
    $('#enable-comment').modal('show');
}
function SaveEnableComment() {
    commentModel.saveEnableComment();
}
function ShowFirstDeleteComment(event) {
    commentModel.comment_id = $(event).data('comment_id');
    commentModel.showFirstDeleteModal();
    $('#delete-comment').modal('show');
}
function ShowSecondDeleteComment() {
    commentModel.showSecondDeleteModal();
}
function ConfirmDeleteComment() {
    $('#form-deleteComment').validate({
        rules: {
            confirmDeleteComment: {
                required: true,
                confirmInput: true
            },
        },
    });
    var validatedata = $("#form-deleteComment").valid();
    if (validatedata == true) {
        commentModel.confirmDeleteComment();
    }
}
$(document).ready(function () {
    $.validator.setDefaults({
        ignore: []
    });
    $.validator.addMethod("confirmInput", function (value, element) {
        if (this.optional(element) || value == "DELETE-COMMENT") {
            return true;
        }
        else {
            return false;
        }
    }, 'Sorry, it must be confirmed by typing "DELETE-COMMENT" into input box above');
});
function ShowCommentReply(event) {
    commentModel.comment_id = $(event).data('comment_id');
    commentModel.showCommentReply();
    $('#view-replies-popup').modal('show');
}
function BackComment() {
    $('#view-replies-popup').modal('hide');
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
function ShowDisableCommentBox(event) {
    commentModel.comment_id = $(event).data('comment_id');
    $('#disable-comment-box').modal('show');
}
function SaveDisableCommentBox() {
    commentModel.saveDisableCommentBox();
}
function ShowEnableCommentBox(event) {
    commentModel.comment_id = $(event).data('comment_id');
    $('#enable-comment-box').modal('show');
}
function SaveEnableCommentBox() {
    commentModel.saveEnableCommentBox();
}
function ShowDisableReplyBox(event) {
    commentModel.replies_id = $(event).data('replies_id');
    $('#disable-reply-box').modal('show');
}
function SaveDisableReplyBox() {
    commentModel.saveDisableReplyBox();
}
function ShowEnableReplyBox(event) {
    commentModel.replies_id = $(event).data('replies_id');
    $('#enable-reply-box').modal('show');
}
function SaveEnableReplyBox() {
    commentModel.saveEnableReplyBox();
}
function ShowFirstDeleteReply(event) {
    commentModel.replies_id = $(event).data('replies_id');
    commentModel.showFirstDeleteReply();
    $('#delete-reply').modal('show');
}
function ShowSecondDeleteReply() {
    commentModel.showSecondDeleteReply();
}
function ConfirmDeleteReply() {
    $('#form-deleteReply').validate({
        rules: {
            confirmReplyComment: {
                required: true,
                confirmInput: true
            },
        },
    });
    var validatedata = $("#form-deleteReply").valid();
    if (validatedata == true) {
        commentModel.confirmDeleteReply();
    }
}
$('#view-replies-popup').on('hidden.bs.modal', function () {
    if (commentModel.switch == true) {
        location.reload();
        commentModel.switch = false;
    }
});
function ShowNoteReportComment(event) {
    commentModel.report_id = $(event).data('report_id');
    commentModel.showNoteReportComment();
    $('#view-replies-popup').modal('show');
}
function FillNoteComment(event) {
    var divfield = $(event).text();
    $("[name=note]").val(divfield);
}
function SaveNoteReportComment() {
    $("#form-note-update").validate({
        rules: {
            note: {
                required: true,
            },
        },
        messages: {}
    });
    var validatedata = $("#form-note-update").valid();
    if (validatedata == true) {
        commentModel.note = $('.note-input').text();
        commentModel.saveNoteReportComment();
    }
}
function EditCommentReportNote() {
    commentModel.showEditReportComment();
}
function ShowEditReportComment(event) {
    commentModel.report_id = $(event).data('report_id');
    commentModel.showEditReportComment();
    $('#view-replies-popup').modal('show');
}
