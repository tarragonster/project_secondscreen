<div class="modal-header" style="padding: 30px 25px 35px 28px; background-color: #EFEFEF; border-bottom-width: 0px">
    <div class="modal-title">
        <span>Reported User Notes</span>
        <button  onclick="EditReportNote()" class="edit-btn" style="display: block">Edit</button>
    </div>
</div>
<div class="outer-content note-content">
    <div class="tab-content">
        <form action="" method='POST' id="form-user-update">
            <div class="row" style="margin: 0">
                <div class="modal-content group-popup outer-table-modal">
                    <span class="lead" style="font-weight: 600!important;">Report Notes</span>
                    <div class="text-note-confirm"><span><?php echo $report[0]['report_note'] ?></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>