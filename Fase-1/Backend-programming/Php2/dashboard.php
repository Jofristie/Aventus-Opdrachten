<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Project.php';
require_once __DIR__ . '/classes/FreelanceProject.php';
require_once __DIR__ . '/classes/SchoolProject.php';

requireLogin();

$user = currentUser();
$profileMessage = '';
$projectMessage = '';

/**
 * Verwerkt een geüploade afbeelding en geeft het opgeslagen pad terug.
 */
function handleUpload(string $inputName): string
{
    if (!empty($_FILES[$inputName]['name']) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed, true)) {
            $filename = uniqid($inputName . '_', true) . '.' . $ext;
            $destination = __DIR__ . '/assets/img/' . $filename;
            if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $destination)) {
                return 'assets/img/' . $filename;
            }
        }
    }

    return '';
}

// ---- Profiel bijwerken ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_profile') {
    $user->getProfile()->setBio($_POST['bio'] ?? '');
    $user->getProfile()->setWebsite($_POST['website'] ?? '');

    $uploadedImage = handleUpload('profileImage');
    if ($uploadedImage !== '') {
        $user->getProfile()->setProfileImage($uploadedImage);
    }

    $user->saveProfile();
    $profileMessage = 'Je profiel is bijgewerkt.';
}

// ---- Project toevoegen ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_project') {
    $category = $_POST['category'] ?? 'school';
    $image = handleUpload('projectImage');

    if ($category === 'freelance') {
        $project = new FreelanceProject(
            $user->getId(),
            $_POST['title'] ?? '',
            $_POST['description'] ?? '',
            $_POST['date'] ?? date('Y-m-d'),
            $image,
            $_POST['client_name'] ?? '',
            (float) ($_POST['budget'] ?? 0)
        );
    } else {
        $project = new SchoolProject(
            $user->getId(),
            $_POST['title'] ?? '',
            $_POST['description'] ?? '',
            $_POST['date'] ?? date('Y-m-d'),
            $image,
            $_POST['school_name'] ?? '',
            $_POST['grade'] ?? ''
        );
    }

    $project->save();
    $projectMessage = 'Project toegevoegd.';
}

// ---- Project verwijderen ----
if (isset($_GET['delete'])) {
    Project::delete((int) $_GET['delete'], $user->getId());
    header('Location: dashboard.php');
    exit;
}

$myProjects = Project::findByUser($user->getId());

$pageTitle = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>

<h1 class="h3 mb-4">Welkom, <?php echo htmlspecialchars($user->getUsername()); ?></h1>

<div class="row g-4 mb-5">
    <div class="col-lg-4">
        <div class="card p-4">
            <h2 class="h5 mb-3">Mijn profiel</h2>
            <div class="text-center mb-3">
                <img src="<?php echo htmlspecialchars($user->getProfile()->getProfileImage()); ?>" class="profile-image" alt="Profielfoto">
            </div>

            <?php if ($profileMessage): ?>
                <div class="alert alert-success py-2"><?php echo htmlspecialchars($profileMessage); ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                <div class="mb-3">
                    <label class="form-label">Bio</label>
                    <textarea class="form-control" name="bio" rows="3"><?php echo htmlspecialchars($user->getProfile()->getBio()); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Website</label>
                    <input type="url" class="form-control" name="website" value="<?php echo htmlspecialchars($user->getProfile()->getWebsite()); ?>" placeholder="https://...">
                </div>
                <div class="mb-3">
                    <label class="form-label">Profielfoto</label>
                    <input type="file" class="form-control" name="profileImage" accept="image/*">
                </div>
                <button type="submit" class="btn btn-dark w-100">Profiel opslaan</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card p-4">
            <h2 class="h5 mb-3">Nieuw project toevoegen</h2>

            <?php if ($projectMessage): ?>
                <div class="alert alert-success py-2"><?php echo htmlspecialchars($projectMessage); ?></div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_project">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Titel</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Categorie</label>
                        <select class="form-select" name="category" id="categorySelect" onchange="toggleCategoryFields()">
                            <option value="school">School</option>
                            <option value="freelance">Freelance</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Datum</label>
                        <input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Afbeelding</label>
                        <input type="file" class="form-control" name="projectImage" accept="image/*">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Beschrijving</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>

                    <div class="col-md-6 school-fields">
                        <label class="form-label">Naam school</label>
                        <input type="text" class="form-control" name="school_name">
                    </div>
                    <div class="col-md-6 school-fields">
                        <label class="form-label">Cijfer</label>
                        <input type="text" class="form-control" name="grade">
                    </div>

                    <div class="col-md-6 freelance-fields d-none">
                        <label class="form-label">Opdrachtgever</label>
                        <input type="text" class="form-control" name="client_name">
                    </div>
                    <div class="col-md-6 freelance-fields d-none">
                        <label class="form-label">Budget (&euro;)</label>
                        <input type="number" step="0.01" class="form-control" name="budget">
                    </div>
                </div>
                <button type="submit" class="btn btn-dark mt-3">Project toevoegen</button>
            </form>
        </div>
    </div>
</div>

<h2 class="h4 mb-3">Mijn projecten</h2>

<?php if (empty($myProjects)): ?>
    <p class="text-muted">Je hebt nog geen projecten toegevoegd.</p>
<?php else: ?>
    <div class="table-responsive">
        <table class="table bg-white align-middle">
            <thead>
                <tr>
                    <th>Titel</th>
                    <th>Categorie</th>
                    <th>Datum</th>
                    <th class="text-end">Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($myProjects as $project): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project->getTitle()); ?></td>
                        <td><span class="badge bg-secondary badge-category"><?php echo htmlspecialchars($project->getCategory()); ?></span></td>
                        <td><?php echo date('d-m-Y', strtotime($project->getDate())); ?></td>
                        <td class="text-end">
                            <a href="project.php?id=<?php echo $project->getId(); ?>" class="btn btn-sm btn-outline-secondary">Bekijk</a>
                            <a href="dashboard.php?delete=<?php echo $project->getId(); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Weet je zeker dat je dit project wilt verwijderen?');">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<script>
function toggleCategoryFields() {
    const category = document.getElementById('categorySelect').value;
    document.querySelectorAll('.school-fields').forEach(el => el.classList.toggle('d-none', category !== 'school'));
    document.querySelectorAll('.freelance-fields').forEach(el => el.classList.toggle('d-none', category !== 'freelance'));
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
