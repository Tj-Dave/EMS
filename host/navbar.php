<style>
/* Move styles to external CSS file for better caching */
.collapse a {
    text-indent: 10px;
}
nav#sidebar {
    background-image: url('assets/uploads/<?php echo htmlspecialchars($_SESSION['system']['cover_img'])?>') !important;
    /* Remove !important if possible and use more specific selectors */
}
</style>


<nav id="sidebar" class="mx-lt-5 bg-dark">
    <div class="sidebar-list">
        <?php
        // Define navigation items in an array for better maintenance
        $navItems = [
            ['page' => 'home', 'icon' => 'fa-home', 'text' => 'Home'],
            ['page' => 'audience', 'icon' => 'fa-th-list', 'text' => 'Event Audience List'],
            ['page' => 'events', 'icon' => 'fa-calendar', 'text' => 'Events']
        ];

        foreach ($navItems as $item): ?>
            <a href="index.php?page=<?php echo htmlspecialchars($item['page']); ?>" 
               class="nav-item nav-<?php echo htmlspecialchars($item['page']); ?>">
                <span class='icon-field'><i class="fa <?php echo $item['icon']; ?>"></i></span>
                <?php echo htmlspecialchars($item['text']); ?>
            </a>
        <?php endforeach; ?>

        <!-- Reports dropdown -->
        <a class="nav-item nav-reports" data-toggle="collapse" href="#reportCollapse" role="button">
            <span class='icon-field'><i class="fa fa-file"></i></span>
            Reports 
            <i class="fa fa-angle-down float-right"></i>
        </a>
        <div class="collapse" id="reportCollapse">
            <a href="index.php?page=audience_report" class="nav-item nav-audience_report">
                <span class='icon-field'></span> Audience Report
            </a>
        </div>
    </div>
</nav>

<script>
// Use event delegation for better performance
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const reportCollapse = document.getElementById('reportCollapse');
    
    // Use const instead of var/let when value won't be reassigned
    const currentPage = '<?php echo isset($_GET['page']) ? htmlspecialchars($_GET['page']) : ''; ?>';
    
    // Add active class to current page
    const activeNav = document.querySelector('.nav-' + currentPage);
    if (activeNav) {
        activeNav.classList.add('active');
    }
});
</script>

