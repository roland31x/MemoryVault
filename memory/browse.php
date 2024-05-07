<?php
    $response = api_request($API_URL . 'Memory/get', "GET", null, $_SESSION['lg-token']);

    if($response === FALSE) {
        header('Location: /404');
        exit;
    }
    
    if($response['status'] != 200) {
        header('Location: /404');
        exit;
    }

    $memories = $response['data'];
    
    $month_memories = [];
    foreach ($memories as $memory) {
        $monthyr = date('Y M', strtotime($memory['postDate']));
        if (!array_key_exists($monthyr, $month_memories)) {
            $month_memories[$monthyr] = [];
        }
        array_push($month_memories[$monthyr], $memory);
    }

    // Convert keys (month years) to timestamps for sorting
    $timestamps = [];
    foreach (array_keys($month_memories) as $key) {
        $timestamps[] = strtotime($key);
    }

    // Sort timestamps in descending order
    rsort($timestamps);

    // Reconstruct the array using sorted timestamps
    $new_month_memories = [];
    foreach ($timestamps as $timestamp) {
        $key = date('Y M', $timestamp);
        $new_month_memories[$key] = $month_memories[$key];
    }

    $month_memories = $new_month_memories;
?>

<div class="flex flex-column flex-center">
    <a href="/memory/submit" class="generic-button" style="margin-top: 15px; width: 30%; text-decoration: none; text-align: center;">
            Create a Memory
    </a>
    <?php foreach($month_memories as $monthyr => $rest): ?>
        <div class="th3 text-light" style="margin-top: 25px;">
            --- <?= $monthyr?> ---
        </div>
        <div class="flex flex-row flex-auto-overflow flex-center">
            <?php foreach($rest as $memory): ?>
            <a href="/memory/<?= $memory['memoryID']; ?>" class="flex flex-column flex-space-between flex-center memory-card">
                <img class="image active" src="data:image/png;base64,<?= $memory['images'][0]['bytes']; ?>" alt="Memory Image">
                <div class="memory-card-title">
                    <?= $memory['name']; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>