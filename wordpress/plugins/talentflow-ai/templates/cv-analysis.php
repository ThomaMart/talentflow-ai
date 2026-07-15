<div class="wrap">

    <h1>CV Analysis</h1>

    <form method="post" enctype="multipart/form-data">

        <?php wp_nonce_field('talentflow_cv_analysis'); ?>

        <table class="form-table">

            <tr>

                <th>Resume (PDF)</th>

                <td>

                    <input
                        type="file"
                        name="cv_file"
                        accept=".pdf"
                        required>

                </td>

            </tr>

        </table>

        <?php submit_button(
            'Analyze CV',
            'primary',
            'talentflow_analyze'
        ); ?>

    </form>

    <?php if (!empty($result)) : ?>

        <?php if (!$result['success']) : ?>

            <div class="notice notice-error inline">
                <p><?= esc_html($result['message']) ?></p>
            </div>

        <?php else : ?>

            <?php $cv = $result['body']; ?>

            <hr>

            <div class="tf-card">

                <div class="tf-header">

                    <div>

                        <h2>
                            👤 <?= esc_html($cv['candidate']['name']) ?>
                        </h2>

                        <p>

                            <?= esc_html($cv['seniority']) ?>

                        </p>

                    </div>

                    <div class="tf-score">

                        ⭐ <?= esc_html($cv['score']) ?>/100

                    </div>

                </div>

                <table class="widefat striped">

                    <tbody>

                        <tr>

                            <th width="180">Email</th>

                            <td>

                                <?= esc_html($cv['candidate']['email']) ?>

                            </td>

                        </tr>

                        <tr>

                            <th>Téléphone</th>

                            <td>

                                <?= esc_html($cv['candidate']['phone']) ?>

                            </td>

                        </tr>

                        <tr>

                            <th>Localisation</th>

                            <td>

                                <?= esc_html($cv['candidate']['location']) ?>

                            </td>

                        </tr>

                        <tr>

                            <th>Expérience</th>

                            <td>

                                <?= esc_html($cv['experience_years']) ?> ans

                            </td>

                        </tr>

                    </tbody>

                </table>

                <h3>Résumé</h3>

                <p>

                    <?= esc_html($cv['summary']) ?>

                </p>



<h3>Compétences</h3>

<?php

$labels = [
    'languages' => '🐍 Languages',
    'frameworks' => '⚙️ Frameworks',
    'devops' => '🐳 DevOps',
    'databases' => '💾 Databases',
    'network' => '📡 Network',
    'embedded' => '🔧 Embedded',
    'ai' => '🤖 AI',
    'other' => '📦 Other'
];

?>

<?php foreach ($cv['skills'] as $category => $skills) : ?>

    <?php if (empty($skills)) continue; ?>

    <h4><?= esc_html($labels[$category] ?? ucfirst($category)) ?></h4>

    <div>

        <?php foreach ($skills as $skill) : ?>

            <span class="tf-badge">

                <?= esc_html($skill) ?>

            </span>

        <?php endforeach; ?>

    </div>

<?php endforeach; ?>

            </div>

        <?php endif; ?>

    <?php endif; ?>

</div>