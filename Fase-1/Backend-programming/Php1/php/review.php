<!DOCTYPE HTML>
<html lang="nl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reviews — Winkel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <style>
        body { background:#f4f1ec; font-family:'DM Sans',sans-serif; }
        .navbar { background:#1a1a1a !important; }
        .navbar-brand { font-family:'Playfair Display',serif; font-size:1.4rem; color:#fff !important; }
        .nav-link { color:rgba(255,255,255,.75) !important; font-size:.9rem; }
        .nav-link:hover { color:#fff !important; }
        .page-title { font-family:'Playfair Display',serif; font-size:2rem; }
        .card { border:none; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .avg-score { font-family:'Playfair Display',serif; font-size:3rem; color:#1a1a1a; line-height:1; }
        .star-light { color:#ddd; }
        .submit_star { cursor:pointer; font-size:1.6rem; transition:color .1s; }
        .progress { border-radius:20px; height:8px; background:#eee; }
        .progress-bar { border-radius:20px; background:#f59e0b !important; }
        .star-row { display:flex; align-items:center; gap:.75rem; margin-bottom:.6rem; }
        .star-row .label { width:1rem; font-size:.85rem; color:#666; text-align:right; }
        .star-row .count { font-size:.8rem; color:#aaa; width:1.5rem; }
        .review-card { background:#fff; border-radius:12px; padding:1rem 1.25rem; margin-bottom:.75rem; box-shadow:0 1px 8px rgba(0,0,0,.06); }
        .avatar-circle { width:42px; height:42px; border-radius:50%; background:#1a1a1a; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.1rem; flex-shrink:0; }
        .modal-content { border-radius:16px; border:none; }
        .modal-header { border-bottom:1px solid #f0ebe4; }
        .form-control { border-radius:8px; border-color:#ddd; }
        .form-control:focus { border-color:#1a1a1a; box-shadow:0 0 0 .2rem rgba(26,26,26,.1); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Winkel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item"><a class="nav-link" href="account.php">Account</a></li>
                <li class="nav-item"><a class="nav-link" href="winkel.php">Winkel</a></li>
                <li class="nav-item"><a class="nav-link" href="winkelwagen.php">Winkelwagen</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="page-title mb-0">Reviews</h1>
        <button type="button" id="add_review" class="btn btn-dark px-4" style="border-radius:10px;font-weight:500;">
            + Schrijf review
        </button>
    </div>

    <!-- Summary card -->
    <div class="card p-4 mb-5">
        <div class="row align-items-center g-4">
            <div class="col-md-3 text-center">
                <div class="avg-score" id="average_rating">0.0</div>
                <div class="my-2" id="main_stars">
                    <i class="fas fa-star star-light"></i>
                    <i class="fas fa-star star-light"></i>
                    <i class="fas fa-star star-light"></i>
                    <i class="fas fa-star star-light"></i>
                    <i class="fas fa-star star-light"></i>
                </div>
                <div class="text-muted" style="font-size:.85rem;"><span id="total_review">0</span> beoordelingen</div>
            </div>
            <div class="col-md-9">
                <div class="star-row">
                    <span class="label">5</span><i class="fas fa-star text-warning" style="font-size:.8rem;"></i>
                    <div class="progress flex-grow-1"><div class="progress-bar" id="five_star_progress" style="width:0%"></div></div>
                    <span class="count" id="total_five_star_review">0</span>
                </div>
                <div class="star-row">
                    <span class="label">4</span><i class="fas fa-star text-warning" style="font-size:.8rem;"></i>
                    <div class="progress flex-grow-1"><div class="progress-bar" id="four_star_progress" style="width:0%"></div></div>
                    <span class="count" id="total_four_star_review">0</span>
                </div>
                <div class="star-row">
                    <span class="label">3</span><i class="fas fa-star text-warning" style="font-size:.8rem;"></i>
                    <div class="progress flex-grow-1"><div class="progress-bar" id="three_star_progress" style="width:0%"></div></div>
                    <span class="count" id="total_three_star_review">0</span>
                </div>
                <div class="star-row">
                    <span class="label">2</span><i class="fas fa-star text-warning" style="font-size:.8rem;"></i>
                    <div class="progress flex-grow-1"><div class="progress-bar" id="two_star_progress" style="width:0%"></div></div>
                    <span class="count" id="total_two_star_review">0</span>
                </div>
                <div class="star-row">
                    <span class="label">1</span><i class="fas fa-star text-warning" style="font-size:.8rem;"></i>
                    <div class="progress flex-grow-1"><div class="progress-bar" id="one_star_progress" style="width:0%"></div></div>
                    <span class="count" id="total_one_star_review">0</span>
                </div>
            </div>
        </div>
    </div>

    <div id="review_content"></div>
</div>

<!-- Modal -->
<div id="review_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-1">
            <div class="modal-header px-4">
                <h5 class="modal-title fw-bold" style="font-family:'Playfair Display',serif;">Schrijf een review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4">
                <div class="text-center mb-4">
                    <i class="fas fa-star submit_star star-light" id="submit_star_1" data-rating="1"></i>
                    <i class="fas fa-star submit_star star-light" id="submit_star_2" data-rating="2"></i>
                    <i class="fas fa-star submit_star star-light" id="submit_star_3" data-rating="3"></i>
                    <i class="fas fa-star submit_star star-light" id="submit_star_4" data-rating="4"></i>
                    <i class="fas fa-star submit_star star-light" id="submit_star_5" data-rating="5"></i>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted" style="font-size:.85rem;">Jouw naam</label>
                    <input type="text" id="user_name" class="form-control" placeholder="Naam">
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted" style="font-size:.85rem;">Je review</label>
                    <textarea id="user_review" class="form-control" rows="3" placeholder="Deel je ervaringen..."></textarea>
                </div>
                <div class="d-grid">
                    <button class="btn btn-dark btn-lg" id="save_review" style="border-radius:10px;">Review versturen</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
var rating_data = 0;

$('#add_review').click(function(){
    var modal = new bootstrap.Modal(document.getElementById('review_modal'));
    modal.show();
});

$(document).on('mouseenter', '.submit_star', function(){
    var rating = $(this).data('rating');
    reset_stars();
    for(var c=1;c<=rating;c++) $('#submit_star_'+c).addClass('text-warning').removeClass('star-light');
});

$(document).on('mouseleave', '.submit_star', function(){
    reset_stars();
    for(var c=1;c<=rating_data;c++) $('#submit_star_'+c).addClass('text-warning').removeClass('star-light');
});

$(document).on('click', '.submit_star', function(){
    rating_data = $(this).data('rating');
});

function reset_stars(){
    for(var c=1;c<=5;c++) $('#submit_star_'+c).addClass('star-light').removeClass('text-warning');
}

$('#save_review').click(function(){
    var user_name = $('#user_name').val();
    var user_review = $('#user_review').val();
    if(!user_name || !user_review){ alert("Vul beide velden in."); return; }
    $.ajax({
        url:"verwerk_review.php", method:"POST",
        data:{rating_data:rating_data, user_name:user_name, user_review:user_review},
        success:function(data){
            bootstrap.Modal.getInstance(document.getElementById('review_modal')).hide();
            load_rating_data();
            alert(data);
        }
    });
});

load_rating_data();

function load_rating_data(){
    $.ajax({
        url:"verwerk_review.php", method:"POST",
        data:{action:'load_data'}, dataType:"JSON",
        success:function(data){
            $('#average_rating').text(data.average_rating);
            $('#total_review').text(data.total_review);

            // Update main stars
            var avg = Math.ceil(data.average_rating);
            $('#main_stars i').each(function(i){ $(this).toggleClass('text-warning', i < avg).toggleClass('star-light', i >= avg); });

            $('#total_five_star_review').text(data.five_star_review);
            $('#total_four_star_review').text(data.four_star_review);
            $('#total_three_star_review').text(data.three_star_review);
            $('#total_two_star_review').text(data.two_star_review);
            $('#total_one_star_review').text(data.one_star_review);

            var t = data.total_review || 1;
            $('#five_star_progress').css('width', (data.five_star_review/t*100)+'%');
            $('#four_star_progress').css('width', (data.four_star_review/t*100)+'%');
            $('#three_star_progress').css('width', (data.three_star_review/t*100)+'%');
            $('#two_star_progress').css('width', (data.two_star_review/t*100)+'%');
            $('#one_star_progress').css('width', (data.one_star_review/t*100)+'%');

            if(data.review_data.length > 0){
                var html = '';
                data.review_data.forEach(function(r){
                    var stars = '';
                    for(var s=1;s<=5;s++) stars += '<i class="fas fa-star '+(r.rating>=s?'text-warning':'star-light')+' me-1" style="font-size:.85rem;"></i>';
                    html += '<div class="review-card d-flex gap-3">';
                    html += '<div class="avatar-circle">'+r.user_name.charAt(0).toUpperCase()+'</div>';
                    html += '<div class="flex-grow-1"><div class="d-flex justify-content-between align-items-start mb-1">';
                    html += '<strong>'+r.user_name+'</strong>';
                    html += '<small class="text-muted">'+r.datetime+'</small></div>';
                    html += '<div class="mb-1">'+stars+'</div>';
                    html += '<p class="mb-0" style="font-size:.9rem;color:#555;">'+r.user_review+'</p>';
                    html += '</div></div>';
                });
                $('#review_content').html(html);
            }
        }
    });
}
</script>
</body>
</html>