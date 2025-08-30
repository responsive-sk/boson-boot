<?php
/**
 * Simple Form Component - No JS dependencies
 * Basic form for testing PHP component system
 */

$action = $action ?? '/submit';
$method = $method ?? 'POST';
$title = $title ?? 'Simple Form';
$fields = $fields ?? [
    ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
    ['name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => false]
];
?>

<form class="simple-form" action="<?= htmlspecialchars($action) ?>" method="<?= $method ?>">
    <h3 class="form-title"><?= htmlspecialchars($title) ?></h3>
    
    <?php foreach ($fields as $field): ?>
        <div class="form-group">
            <label for="<?= $field['name'] ?>" class="form-label">
                <?= htmlspecialchars($field['label']) ?>
                <?php if ($field['required'] ?? false): ?>
                    <span class="required">*</span>
                <?php endif; ?>
            </label>
            
            <?php if ($field['type'] === 'textarea'): ?>
                <textarea 
                    id="<?= $field['name'] ?>" 
                    name="<?= $field['name'] ?>" 
                    class="form-control"
                    <?= ($field['required'] ?? false) ? 'required' : '' ?>
                    rows="4"></textarea>
            <?php else: ?>
                <input 
                    type="<?= $field['type'] ?>" 
                    id="<?= $field['name'] ?>" 
                    name="<?= $field['name'] ?>" 
                    class="form-control"
                    <?= ($field['required'] ?? false) ? 'required' : '' ?>>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </div>
</form>

<style>
/* Simple form styles */
.simple-form {
    max-width: 400px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: white;
}

.form-title {
    margin: 0 0 20px 0;
    color: #333;
    font-size: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #333;
}

.required {
    color: #dc3545;
}

.form-control {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.form-actions {
    margin-top: 20px;
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-primary {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border-color: #6c757d;
}

.btn:hover {
    opacity: 0.8;
}
</style>
