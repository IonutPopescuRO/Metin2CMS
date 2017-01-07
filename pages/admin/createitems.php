<?php
	include 'include/functions/createitems.php';
?>
<div class="container">
    <form action="" method="post" class="form-horizontal">

        <div class="form-group">
            <label class="control-label" for="name">
                <?php print $lang[ 'char-name']; ?>
            </label>
            <input class="form-control" name="name" id="name" type="text">
        </div>

        <div class="form-group">
            <label class="control-label" for="vnum">vNum</label>
            <input class="form-control" name="vnum" id="vnum" type="number">
        </div>

        <div class="form-group">
            <label class="control-label" for="count">
                <?php print $lang[ 'items-number']; ?>
            </label>
            <input class="form-control" name="count" id="count" type="number" value="1">
        </div>

        <div class="form-group">
            <label class="control-label">
                <?php print $lang['bonuses']; ?>
            </label>
        </div>

        <?php for($i=0;$i<=6;$i++) { ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-10">
                    <select class="form-control" name="attrtype<?php print $i; ?>">
                        <option value="0"><?php print $lang['no']; ?></option>
                        <?php print $form_bonuses; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input class="form-control" name="attrvalue<?php print $i; ?>" type="number" value="0">
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if(check_item_column( "applytype0")) { ?>
        <div class="form-group">
            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#sash" aria-expanded="false" aria-controls="sash">
                <?php print $lang[ 'more_bonuses']; ?>
            </a>
            <div class="collapse" id="sash">
                <div class="form-group">
                    <label class="control-label" for="absorption">
                        <?php print $lang[ 'bonus_absorption']; ?>
                    </label>
                    <input class="form-control" name="absorption" id="absorption" type="number" value="18">
                </div>
                <div class="form-group">
                    <label class="control-label">
                        <?php print $lang[ 'bonuses']; ?>
                    </label>
                </div>
                <?php for($i=0;$i<=7;$i++) { ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-10">
                            <select class="form-control" name="applytype<?php print $i; ?>">
                                <option value="0">No</option>
                                <?php print $form_bonuses; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control" name="applyvalue<?php print $i; ?>" type="number" value="0">
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        <?php } ?>
        <div class="form-group">
            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#sockets" aria-expanded="false" aria-controls="sockets">
                <?php print $lang[ 'stones']; ?>
            </a>
            <div class="collapse" id="sockets">
                <div class="form-group">
                    <label class="control-label" for="socket0">
                        <?php print $lang[ 'stone']; ?> (1)</label>
                    <input class="form-control" name="socket0" id="socket0" type="number" value="">
                </div>
                <div class="form-group">
                    <label class="control-label" for="socket1">
                        <?php print $lang[ 'stone']; ?> (2)</label>
                    <input class="form-control" name="socket1" id="socket1" type="number" value="">
                </div>
                <div class="form-group">
                    <label class="control-label" for="socket2">
                        <?php print $lang[ 'stone']; ?> (3)</label>
                    <input class="form-control" name="socket2" id="socket2" type="number" value="">
                </div>
            </div>
        </div>
        <div class="form-group">
            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#time" aria-expanded="false" aria-controls="time">
                <?php print $lang[ 'item_time']; ?> (Min.)
            </a>
            <div class="collapse" id="time">


                <div class="form-group">
                    <label class="control-label" for="time">
                        <?php print $lang[ 'item_time']; ?>
                    </label>
                    <input class="form-control" name="time" id="time" type="number" value="0">
                </div>
            </div>
        </div>
        <div class="form-group">
            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#time2" aria-expanded="false" aria-controls="time2">
                <?php print $lang[ 'item_time']. ' - '.$lang[ 'costumes']; ?> (Min.)
            </a>
            <div class="collapse" id="time2">
                <div class="form-group">
                    <label class="control-label" for="time2">
                        <?php print $lang[ 'item_time']; ?> (Costume)</label>
                    <input class="form-control" name="time2" id="time2" type="number" value="0">
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-2">
                    <input class="btn btn-success" name="add" value="<?php print $lang['create']; ?>" type="submit">
                </div>
                <div class="col-sm-2">
                    <input class="btn btn-warning" value="Resetează" type="reset">
                </div>
            </div>
        </div>
    </form>
</div>