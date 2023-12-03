<div id="edit-modal" class="modal" style="display: none;">
    <!-- Modal content for editing the record -->
    <form method="post" action="update_record.php">
        <input type="hidden" id="edit-record-id" name="record_id">
        <label for="edit-name">Name:</label>
        <input type="text" id="edit-name" name="name">
        <!-- Other input fields for editing -->
        <button type="submit" name="update">Update</button>
        <button type="button" onclick="closeEditModal()">Cancel</button>
    </form>
</div>
