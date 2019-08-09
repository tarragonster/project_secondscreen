<div class="outer-user-live">
    <div class="sub-menu">
        <div>
            <span class="submenu-title">Users</span>
        </div>
        <div class="submenu-content">
            <div class="cover-submenu-item">
                <a href="<?php echo base_url('user'); ?>"
                   class="submenu-item text-uppercase <?php echo isset($sub_id) && $sub_id == 21 ? ' active' : ''; ?>">View
                    Users</a>
            </div>
            <div class="cover-submenu-item">
                <a href="<?php echo base_url('user/reports'); ?>"
                   class="submenu-item text-uppercase <?php echo isset($sub_id) && $sub_id == 23 ? ' active' : ''; ?>">Reported
                    Users</a>
            </div>
        </div>
    </div>

    <div class="not-menu">
        <form action="" method="get">
            <div class="search-container">
                <div class="outer-search dataTables_filter">
                    <i class="fa fa-search"></i>
                    <input name='key' value="<?php echo isset($conditions['key']) ? $conditions['key'] : '' ?>"
                           type="search" class="form-control input-sm" placeholder="Search Users"/>
                </div>
                <button type="submit" class="btn-nothing" name="cmd" value="nothing" style="display: none;">&nbsp;
                </button>
            </div>
            <div class="col-xs-12 list-content">
                <div class="box">
                    <div class="card-box table-responsive">
                        <div class="user_table">
                            <table id="example3" class="table table-bordered table-hover">
                                <?php $this->load->view('admin/users/table_header_report') ?>
                                <tbody>
                                <?php
                                if (isset($reports) && is_array($reports)) {
                                    foreach ($reports as $row) { ?>
                                        <tr>
                                            <td class="header-item-content item-style">
                                                <div style="width: 50px;height: 50px;">
                                                    <img style="width: 100%; height: 100%;border-radius: 29.5px;"
                                                         src="<?= media_thumbnail($row['avatar'], 70) ?>"/>
                                                </div>
                                            </td>
                                            <td class="header-item-content item-style"><?php echo $row['report_id'] ?></td>
                                            <td class="header-item-content item-style" style="font-weight: 900;">
                                                <?php echo $row['full_name'] ?><br>
                                                <span style="font-weight: 500!important;">@<?php echo $row['user_name'] ?></span>
                                            </td>
                                            <td class="header-item-content item-style"><?php echo $row['reporter_name'] ?></td>

                                            <td class="header-item-content item-style"><?php echo date('m/d/Y h:iA', $row['created_at']) ?></td>
                                            <td class="header-item-content item-style status-tb">1</td>
                                            <td class="header-item-content item-style">
                                                <div class="dropdown">
                                                <span class="btnAction dropdown-toggle"
                                                      data-toggle="dropdown"> <i class="fa fa-ellipsis-h"
                                                                                 style="color: #d8d8d8"></i></span>
                                                    <ul class="dropdown-menu" id="customDropdown">
                                                        <li class="text-uppercase view-user-click"
                                                            data-user_id="<?= $row['report_id'] ?>"><a
                                                                    class="drp-items"><span>
                                                                View Notes
                                                            </span></a>
                                                        </li>
                                                        <li class="text-uppercase"
                                                            data-user_id="<?= $row['report_id'] ?>">
                                                            <a class="drp-items"><span>
                                                                View User
                                                            </span></a>
                                                        </li>
                                                        <li class="text-uppercase"
                                                            data-user_id="<?= $row['report_id'] ?>">
                                                            <a class="drp-items"><span>
                                                                Enable User
                                                            </span></a>
                                                        </li>
                                                        <li class="text-uppercase"
                                                            data-user_id="<?= $row['report_id'] ?>">
                                                            <a class="drp-items"><span>
                                                                Remove Report
                                                            </span></a>
                                                        </li>
                                                        <li class="text-uppercase"
                                                            data-user_id="<?= $row['user_id'] ?>"><a
                                                                    class="drp-items"><span>
                                                                Delete User</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                            <!--pagination-->

                            <?php
                            $has_items = isset($paging) && $paging['total'] > 0;
                            $dropdown_size = $has_items && isset($paging['dropdown-size']) ? $paging['dropdown-size'] - 25 : '40';
                            ?>
                            <div class="row"
                                 style="padding: 0 20px;padding-top: 10px; margin: 0; background: white; border-bottom-left-radius: 6px;border-bottom-right-radius: 6px;">
                                <?php if (isset($paging)) : ?>
                                    <div class="col-xs-4">
                                        <?php
                                        $per_page = isset($conditions['per_page']) ? $conditions['per_page'] * 1 : 0;
                                        ?>
                                        <div class="dataTables_info" id="table-driver_info" role="status"
                                             aria-live="polite">
                                            <?php if ($paging['total'] > 0) : ?>
                                                Showing <?= $paging['from'] ?> to <?= $paging['to'] ?> of <?= $paging['total'] ?> items
                                            <?php else: ?>
                                                No Results
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-8">
                                        <?php if ($has_items): ?>
                                            <div class="dataTables_paginate paging_bootstrap" style="float: right">
                                                <?php echo $this->pagination->create_links(); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="per_page m-r-15"
                                             style="float: right; margin-top: 2px; margin-left: 30px">
                                            <label>
                                                <select name="per_page" class="form-control input-sm">
                                                    <option value="25"<?php echo $per_page == 25 ? ' selected' : '' ?>>
                                                        25
                                                    </option>
                                                    <option value="50"<?php echo $per_page == 50 ? ' selected' : '' ?>>
                                                        50
                                                    </option>
                                                </select> &nbsp;
                                                Items per page
                                            </label>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
