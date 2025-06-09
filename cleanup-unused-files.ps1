Write-Host "Starting automatic cleanup of unused files..." -ForegroundColor Green

# Define paths to remove
$pathsToRemove = @(
    "public\adminlte\docs",
    "public\adminlte\pages", 
    "public\adminlte\build",
    "public\adminlte\plugins\bootstrap4-duallistbox",
    "public\adminlte\plugins\bs-custom-file-input",
    "public\adminlte\plugins\bs-stepper",
    "public\adminlte\plugins\codemirror",
    "public\adminlte\plugins\daterangepicker",
    "public\adminlte\plugins\dropzone",
    "public\adminlte\plugins\ekko-lightbox",
    "public\adminlte\plugins\filterizr",
    "public\adminlte\plugins\flot",
    "public\adminlte\plugins\fullcalendar",
    "public\adminlte\plugins\inputmask",
    "public\adminlte\plugins\ion-rangeslider",
    "public\adminlte\plugins\jqvmap",
    "public\adminlte\plugins\jszip",
    "public\adminlte\plugins\moment",
    "public\adminlte\plugins\overlayScrollbars",
    "public\adminlte\plugins\pdfmake",
    "public\adminlte\plugins\raphael",
    "public\adminlte\plugins\select2",
    "public\adminlte\plugins\sparklines",
    "public\adminlte\plugins\summernote",
    "public\adminlte\plugins\tempusdominus-bootstrap-4",
    "public\adminlte\plugins\toastr",
    "public\adminlte\plugins\uplot",
    "public\adminlte\plugins\datatables-colreorder",
    "public\adminlte\plugins\datatables-fixedcolumns",
    "public\adminlte\plugins\datatables-fixedheader",
    "public\adminlte\plugins\datatables-keytable",
    "public\adminlte\plugins\datatables-rowgroup",
    "public\adminlte\plugins\datatables-rowreorder",
    "public\adminlte\plugins\datatables-scroller",
    "public\adminlte\plugins\datatables-searchbuilder",
    "public\adminlte\plugins\datatables-searchpanes",
    "public\adminlte\plugins\datatables-select",
    "public\adminlte\plugins\datatables-staterestore",
    "public\adminlte\plugins\jquery-mapael",
    "public\adminlte\plugins\jsgrid"
)

# Files to remove
$filesToRemove = @(
    "public\adminlte\.babelrc.js",
    "public\adminlte\.browserslistrc", 
    "public\adminlte\.eslintrc.json",
    "public\adminlte\Gruntfile.js",
    "public\adminlte\package.json",
    "public\adminlte\package-lock.json",
    "public\adminlte\composer.json",
    "public\adminlte\composer.lock",
    "public\adminlte\plugins\jquery\jquery.slim.js",
    "public\adminlte\plugins\jquery\jquery.slim.min.js",
    "public\RuangAdmin\404.html",
    "public\RuangAdmin\alerts.html",
    "public\RuangAdmin\blank.html",
    "public\RuangAdmin\buttons.html",
    "public\RuangAdmin\cards.html",
    "public\RuangAdmin\charts.html",
    "public\RuangAdmin\colors.html",
    "public\RuangAdmin\datatables.html",
    "public\RuangAdmin\forms.html",
    "public\RuangAdmin\index.html",
    "public\RuangAdmin\login.html",
    "public\RuangAdmin\register.html",
    "public\RuangAdmin\tables.html",
    "public\RuangAdmin\ui-typography.html",
    "public\RuangAdmin\utilities-animation.html",
    "public\RuangAdmin\utilities-border.html",
    "public\RuangAdmin\utilities-color.html",
    "public\RuangAdmin\utilities-other.html"
)

$totalRemoved = 0
$totalSize = 0

# Remove directories
foreach ($path in $pathsToRemove) {
    if (Test-Path $path) {
        try {
            $size = (Get-ChildItem $path -Recurse | Measure-Object -Property Length -Sum).Sum
            Remove-Item $path -Recurse -Force
            $totalSize += $size
            $totalRemoved++
            Write-Host "✓ Removed directory: $path" -ForegroundColor Yellow
        }
        catch {
            Write-Host "✗ Failed to remove: $path - $($_.Exception.Message)" -ForegroundColor Red
        }
    }
}

# Remove individual files
foreach ($file in $filesToRemove) {
    if (Test-Path $file) {
        try {
            $size = (Get-Item $file).Length
            Remove-Item $file -Force
            $totalSize += $size
            $totalRemoved++
            Write-Host "✓ Removed file: $file" -ForegroundColor Yellow
        }
        catch {
            Write-Host "✗ Failed to remove: $file - $($_.Exception.Message)" -ForegroundColor Red
        }
    }
}

$sizeInMB = [math]::Round($totalSize / 1MB, 2)
Write-Host "`nCleanup completed!" -ForegroundColor Green
Write-Host "Total items removed: $totalRemoved" -ForegroundColor Green
Write-Host "Total space freed: $sizeInMB MB" -ForegroundColor Green