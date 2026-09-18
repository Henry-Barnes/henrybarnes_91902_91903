<div class="char-details">
    <div class="character-name"><?= htmlspecialchars($character); ?></div>

    <div class="play-title">
        <a class="play" title="<?= htmlspecialchars($crew); ?>" href="<?= $click_type . "crew" . $click_term . urlencode($crew) ?>">
        <?= htmlspecialchars($crew); ?></a>
    </div> <!-- / play-title -->

    <?php
        $all_icons = [
            [$fruit_type, $click_type . "fruit_type" . $click_term . urlencode($fruit_type), $fruit_icon],
            [$origin, $click_type . "origin" . $click_term . urlencode($origin), $origin_icon],
        ];
    ?>

    <div class="icon-row">
        <?php foreach ($all_icons as $icon) { ?>
            <a title="<?= htmlspecialchars($icon[0]); ?>" href="<?= $icon[1]; ?>">
            <img src="<?= htmlspecialchars($icon[2]); ?>" alt="<?= htmlspecialchars($icon[0]); ?>"></a>
        <?php } ?>
    </div> <!-- / icon-row -->

    <?php if ($bounty > 0) { ?>
        <div class="bounty pad-10">
            Bounty: ฿<?= number_format($bounty); ?>
        </div>
    <?php } ?>

    <div class="description pad-10">
        <?= htmlspecialchars($find_rs['description']); ?>
    </div> <!-- / description -->

    <div class="trait-tags">
        <?php
            $all_traits = [$trait1, $trait2, $trait3];

            foreach ($all_traits as $trait) {
                if ($trait != "n/a") {
                    ?>
                    <a class="trait pad-10" href="<?= $click_type . "trait" . $click_term . urlencode($trait); ?>">
                    <?= htmlspecialchars($trait); ?></a>
                    <?php
                }
            }
        ?>
    </div> <!-- / trait-tags -->

    <?php if (isset($_SESSION['admin'])) { ?>
        <div class="tools pad-10 text-large">
            <a class="nav-button pad-10-round" href="index.php?page=admin/edit&ID=<?= $ID; ?>">
                <i class="fa-solid fa-pen-nib"></i></a>

            <?php if ($featured == "") { ?>
                <a class="nav-button pad-10-round" href="index.php?page=admin/delete_confirm&ID=<?= $ID; ?>">
                    <i class="fa-solid fa-trash"></i></a>
            <?php } else { ?>
                <a title="Featured item (can't be deleted)" class="nav-button grey-button" href="#">
                    <i class="fa-solid fa-trash"></i></a>
            <?php } ?>
        </div> <!-- / tools -->
    <?php } ?>

</div> <!-- / char-details -->
