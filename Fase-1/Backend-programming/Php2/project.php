<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Project.php';
require_once __DIR__ . '/classes/FreelanceProject.php';
require_once __DIR__ . '/classes/SchoolProject.php';

$id = (int) ($_GET['id'] ?? 0);
$project = Project::findById($id);

if (!$project) {
    http_response_code(404);
    $pageTitle = 'Niet gevonden';
    require __DIR__ . '/includes/header.php';
    echo '<p class="text-danger">Dit project bestaat niet (meer).</p>';
    echo '<a href="index.php" class="btn btn-dark">Terug naar overzicht</a>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$owner = User::findById($project->getUserId());
$pageTitle = $project->getTitle();

require __DIR__ . '/includes/header.php';
?>

<a href="index.php" class="btn btn-outline-secondary btn-sm mb-4">&larr; Terug naar overzicht</a>

<div class="row g-4">
    <div class="col-md-6">
        <img src="<?php echo htmlspecialchars($project->getImage()); ?>" class="img-fluid rounded shadow-sm" alt="<?php echo htmlspecialchars($project->getTitle()); ?>">
    </div>
    <div class="col-md-6">
        <span class="badge bg-secondary badge-category mb-2"><?php echo htmlspecialchars($project->getCategory()); ?></span>
        <h1 class="h2"><?php echo htmlspecialchars($project->getTitle()); ?></h1>
        <p class="text-muted"><?php echo date('d-m-Y', strtotime($project->getDate())); ?></p>
        <p><?php echo nl2br(htmlspecialchars($project->getDescription())); ?></p>

        <?php if ($project instanceof FreelanceProject): ?>
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item px-0"><strong>Opdrachtgever:</strong> <?php echo htmlspecialchars($project->getClientName()); ?></li>
                <li class="list-group-item px-0"><strong>Budget:</strong> &euro; <?php echo number_format($project->getBudget(), 2, ',', '.'); ?></li>
            </ul>
        <?php elseif ($project instanceof SchoolProject): ?>
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item px-0"><strong>School:</strong> <?php echo htmlspecialchars($project->getSchoolName()); ?></li>
                <li class="list-group-item px-0"><strong>Cijfer:</strong> <?php echo htmlspecialchars($project->getGrade()); ?></li>
            </ul>
        <?php endif; ?>

        <?php if ($owner): ?>
            <p class="text-muted">Gemaakt door <strong><?php echo htmlspecialchars($owner->getUsername()); ?></strong></p>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
