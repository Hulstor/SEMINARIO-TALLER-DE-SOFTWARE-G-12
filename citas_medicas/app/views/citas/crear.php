<h2>Crear Cita</h2>

<form method="POST" action="index.php?controller=cita&action=guardar">

<label>Paciente</label>
<select name="paciente_id" required>

<?php foreach($pacientes as $p): ?>

<option value="<?= $p['id'] ?>">
<?= htmlspecialchars($p['nombre']) ?> <?= htmlspecialchars($p['apellido']) ?>
</option>

<?php endforeach; ?>

</select>

<br><br>

<label>Médico</label>
<select name="medico_id" required>

<?php foreach($medicos as $m): ?>

<option value="<?= $m['id'] ?>">
<?= htmlspecialchars($m['nombre']) ?> <?= htmlspecialchars($m['apellido']) ?>
</option>

<?php endforeach; ?>

</select>

<br><br>

<label>Fecha</label>
<input type="date" name="fecha" required min="<?= date('Y-m-d') ?>">

<br><br>

<label>Hora Inicio</label>
<input type="time" name="hora_inicio" required>

<br><br>

<label>Motivo</label>
<textarea name="motivo" minlength="5" maxlength="200"></textarea>

<br><br>

<button type="submit">Guardar Cita</button>

</form>