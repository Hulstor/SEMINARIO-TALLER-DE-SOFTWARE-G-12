<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="table-card">
    <div class="table-header">
        <h2>Gestión de citas</h2>
        <a href="index.php?controller=cita&action=crear" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nueva cita
        </a>
    </div>

    <div class="toolbar">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Buscar por paciente, médico, fecha o estado..." data-search-target="tabla-citas">
        </div>
    </div>

    <?php if (!empty($citas)): ?>
        <div class="table-responsive">
            <table>
                <thead>
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
                </thead>
                <tbody id="tabla-citas">
                    <?php foreach ($citas as $c): ?>
                        <tr>
                            <td><?= htmlspecialchars($c['id']); ?></td>
                            <td><?= htmlspecialchars($c['paciente']); ?></td>
                            <td><?= htmlspecialchars($c['medico']); ?></td>
                            <td><?= htmlspecialchars($c['fecha']); ?></td>
                            <td><?= htmlspecialchars($c['hora_inicio']); ?></td>
                            <td><?= htmlspecialchars($c['hora_fin']); ?></td>
                            <td>
                                <?php if ($c['estado'] === 'pendiente'): ?>
                                    <span class="badge badge-pendiente">Pendiente</span>
                                <?php elseif ($c['estado'] === 'completada'): ?>
                                    <span class="badge badge-completada">Completada</span>
                                <?php else: ?>
                                    <span class="badge badge-cancelada">Cancelada</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="index.php?controller=cita&action=completar&id=<?= $c['id']; ?>" class="btn btn-success">
                                        <i class="fa-solid fa-check"></i> Completar
                                    </a>

                                    <a href="index.php?controller=cita&action=cancelar&id=<?= $c['id']; ?>" class="btn btn-warning">
                                        <i class="fa-solid fa-ban"></i> Cancelar
                                    </a>

                                    <?php if (($_SESSION['usuario_rol'] ?? '') === 'admin'): ?>
                                        <a href="index.php?controller=cita&action=eliminar&id=<?= $c['id']; ?>" class="btn btn-danger" data-confirm="¿Deseas eliminar esta cita?">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty-box">
            <i class="fa-solid fa-calendar-plus" style="font-size:32px; margin-bottom:10px;"></i>
            <p>No hay citas registradas.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>