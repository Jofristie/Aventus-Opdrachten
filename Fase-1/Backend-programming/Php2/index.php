<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Project.php';
require_once __DIR__ . '/classes/FreelanceProject.php';
require_once __DIR__ . '/classes/SchoolProject.php';

$pageTitle = 'Projecten';

// Filteroptie per categorie via GET-parameter, bv. index.php?category=freelance
$selectedCategory = $_GET['category'] ?? 'all';
$allowedCategories = ['all', 'school', 'freelance'];
if (!in_array($selectedCategory, $allowedCategories, true)) {
    $selectedCategory = 'all';
}

$projects = Project::findAll($selectedCategory === 'all' ? null : $selectedCategory);

require __DIR__ . '/includes/header.php';
?>

<div class="hero">
    <h1 class="display-5 fw-bold">Welkom bij mijn portfolio</h1>
    <p class="lead mb-0">Een overzicht van mijn school- en freelanceprojecten.</p>
</div>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <h2 class="h4 mb-3 mb-md-0">Alle projecten</h2>
    <div class="filter-bar">
        <a href="index.php?category=all" class="btn btn-sm <?php echo $selectedCategory === 'all' ? 'btn-dark' : 'btn-outline-dark'; ?>">Alles</a>
        <a href="index.php?category=school" class="btn btn-sm <?php echo $selectedCategory === 'school' ? 'btn-dark' : 'btn-outline-dark'; ?>">School</a>
        <a href="index.php?category=freelance" class="btn btn-sm <?php echo $selectedCategory === 'freelance' ? 'btn-dark' : 'btn-outline-dark'; ?>">Freelance</a>
    </div>
</div>

<?php if (empty($projects)): ?>
    <p class="text-muted">Er zijn nog geen projecten in deze categorie.</p>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($projects as $project): ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card project-card">
                    <img src="<?php echo htmlspecialchars($project->getImage()); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($project->getTitle()); ?>">
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary badge-category align-self-start mb-2"><?php echo htmlspecialchars($project->getCategory()); ?></span>
                        <h5 class="card-title"><?php echo htmlspecialchars($project->getTitle()); ?></h5>
                        <p class="card-text text-muted small"><?php echo date('d-m-Y', strtotime($project->getDate())); ?></p>
                        <p class="card-text flex-grow-1"><?php echo htmlspecialchars(mb_strimwidth($project->getDescription(), 0, 100, '...')); ?></p>
                        <a href="project.php?id=<?php echo $project->getId(); ?>" class="btn btn-outline-dark mt-auto">Bekijk project</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
