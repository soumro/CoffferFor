<div class="center">

    <div class="row">
        <h3 class="blue-text">
            Your Item
        </h3>
        <form action="<?= site_url('/item') ?>" method="post" class="col s12">

            <p class="input-field s6">
                <label for="id_name">Item Id Name:</label>
                <input type="text" name="id_name" id="id_name" value="<?= $idName ?>" <?= $isFieldDisabled ? 'disabled' : '' ?> required="required" placeholder="Your Unique item Id Name" />
            </p>
            <p class="input-field">
                <label for="item_name">Item Name:</label>
                <input type="text" name="item_name" id="item_name" value="<?= $itemName ?>" <?= $isFieldDisabled ? 'disabled' : '' ?> placeholder="Item Name" required="required" />
            </p>
            <p class="input-field">
                <label for="business_name">Business Name:</label>
                <input type="text" name="business_name" id="business_name" value="<?= $businessName ?>"
                    <?= $isFieldDisabled ? 'disabled' : '' ?> placeholder="Business Name" />
            </p>
            <p class="input-field">
                <label for="summary">Summary:</label>
                <textarea name="summary" id="summary" class="materialize-textarea" placeholder="Item Summary..... ✍️"
                    <?= $isFieldDisabled ? 'disabled' : '' ?>><?= $summary ?></textarea>
            </p>
            <p class="input-field">
                <label for="price">Price:</label>
                <input type="text" name="price" id="price" <?= $isFieldDisabled ? 'disabled' : '' ?> step="0.01"
                    value="<?= $price ?>" placeholder="Price">
            </p>
            <p>
                <button type="submit" name="item_submit" <?= $isFieldDisabled ? 'disabled' : '' ?> value="1"
                    class="bold btn-large waves-effect">Save</button>
            </p>
        </form>
        <?php if (strlen(isset($shareItemUrl)) >= 1): ?>
            <p>
                <input type="text" readonly="readonly" value="<?= $shareItemUrl ?>" onclick="this.select()">
            </p>
        <?php endif ?>
    </div>
</div>