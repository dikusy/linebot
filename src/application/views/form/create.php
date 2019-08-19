<?php echo validation_errors(); ?>

<?php echo form_open('/form/create'); ?>

    <label for="name">Name</label>
    <input type="input" name="name" /><br />

    <label for="category">Category</label>
    <input type="input" name="category" /><br />

    <label for="open_at">Open_at</label>
    <input type="input" name="open_at" /><br />

    <label for="close_at">Close_at</label>
    <input type="input" name="close_at" /><br />

    <label for="holiday">Holiday</label>
    <input type="input" name="holiday" /><br />

    <label for="day_average">Day_average</label>
    <input type="input" name="day_average" /><br />

    <label for="night_average">Night_average</label>
    <input type="input" name="night_average" /><br />

    <label for="url">URL</label>
    <input type="input" name="url" /><br />

    <label for="address">Adress</label>
    <textarea name="address"></textarea><br />
    
    <label for="tel">Telephone</label>
    <input type="input" name="tel" /><br />

    <label for="name">img</label>
    <input type="file" name="img" size="20" /><br />

    <input type="submit" name="submit" value="Create store item" />

</form>