<?php echo validation_errors(); ?>

<?php echo form_open_multipart('/form/create'); ?>

    <label for="name">Name</label>
    <input type="text" name="name" /><br />

    <label for="category">Category</label>
    <input type="text" name="category" /><br />

    <label for="open_at">Open_at</label>
    <input type="text" name="open_at" /><br />

    <label for="close_at">Close_at</label>
    <input type="text" name="close_at" /><br />

    <label for="holiday">Holiday</label>
    <input type="text" name="holiday" /><br />

    <label for="day_average">Day_average</label>
    <input type="text" name="day_average" /><br />

    <label for="night_average">Night_average</label>
    <input type="text" name="night_average" /><br />

    <label for="url">URL</label>
    <input type="text" name="url" /><br />

    <label for="address">Adress</label>
    <textarea name="address"></textarea><br />
    
    <label for="tel">Telephone</label>
    <input type="text" name="tel" /><br />

    <label for="name">img</label>
    <input type="file" name="img" size="20"/><br />

    <input type="submit" value="upload"  />

</form>