<h2>Lista de Citas</h2>

<a href="index.php?controller=cita&action=crear">Nueva Cita</a>

<table border="1">

<tr>
<th>ID</th>
<th>Paciente</th>
<th>Médico</th>
<th>Fecha</th>
<th>Inicio</th>
<th>Fin</th>
<th>Estado</th>
<th>Acciones</th>
</tr>

<?php foreach($citas as $c): ?>

<tr>

<td><?= htmlspecialchars($c['paciente']) ?></td>
<td><?= htmlspecialchars($c['medico']) ?></td>
<td><?= htmlspecialchars($c['fecha']) ?></td>
<td><?= htmlspecialchars($c['hora_inicio']) ?></td>
<td><?= htmlspecialchars($c['hora_fin']) ?></td>
<td><?= htmlspecialchars($c['estado']) ?></td>

<td>

<a href="index.php?controller=cita&action=completar&id=<?= $c['id'] ?>">Completar</a>

<a href="index.php?controller=cita&action=cancelar&id=<?= $c['id'] ?>">Cancelar</a>

<a href="index.php?controller=cita&action=eliminar&id=<?= $c['id'] ?>">Eliminar</a>

</td>

</tr>

<?php endforeach; ?>

</table>