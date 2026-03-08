

<h2>Sistema de Citas Médicas</h2>

<p>
Usuario: <b><?= $_SESSION['usuario_nombre'] ?></b>
| Rol: <b><?= $_SESSION['usuario_rol'] ?></b>
</p>

<a href="index.php?controller=auth&action=logout">Cerrar sesión</a>

<br><br>

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

<td><?= htmlspecialchars($c['id']) ?></td>
<td><?= htmlspecialchars($c['paciente']) ?></td>
<td><?= htmlspecialchars($c['medico']) ?></td>
<td><?= htmlspecialchars($c['fecha']) ?></td>
<td><?= htmlspecialchars($c['hora_inicio']) ?></td>
<td><?= htmlspecialchars($c['hora_fin']) ?></td>
<td><?= htmlspecialchars($c['estado']) ?></td>

<td>

<a href="index.php?controller=cita&action=completar&id=<?= $c['id'] ?>">Completar</a>

<a href="index.php?controller=cita&action=cancelar&id=<?= $c['id'] ?>">Cancelar</a>

<?php if($_SESSION['usuario_rol'] == 'admin'): ?>

<a href="index.php?controller=cita&action=eliminar&id=<?= $c['id'] ?>">Eliminar</a>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</table>