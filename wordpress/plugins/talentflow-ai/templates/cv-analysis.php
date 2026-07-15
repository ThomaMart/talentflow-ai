<?php
/* TalentFlow AI - Modern CV Analysis Template */
?>
<div class="wrap">
<h1>🤖 TalentFlow AI</h1>
<p class="description">Analyze resumes and compare candidates against job descriptions using a local LLM.</p>

<form method="post" enctype="multipart/form-data" class="tf-card">
<?php wp_nonce_field('talentflow_cv_analysis'); ?>
<table class="form-table">
<tr><th>Resume (PDF)</th><td><input type="file" name="cv_file" accept=".pdf" required></td></tr>
<tr><th>Job Description</th><td>
<textarea name="job_description" rows="10" style="width:100%;" placeholder="Paste the job description here (optional)..."></textarea>
<p class="description">Paste a job description to calculate a compatibility score.</p>
</td></tr>
</table>
<?php submit_button('Analyze Resume','primary','talentflow_analyze'); ?>
</form>

<?php if (!empty($result)) : ?>
<?php if (!$result['success']) : ?>
<div class="notice notice-error inline"><p><?= esc_html($result['message']) ?></p></div>
<?php else : ?>
<?php $cv = $result['body']; ?>

<hr>

<div class="tf-header">

    <div>

        <h2>
            👤 <?= esc_html($cv['candidate']['name']) ?>
        </h2>

        <p>
            <?= esc_html($cv['seniority']) ?>
        </p>

    </div>

    <div class="tf-scores">

        <div class="tf-score">

            <small>Resume Score</small>

            <div>

                ⭐ <?= esc_html($cv['score']) ?>/100

            </div>

        </div>

        <?php if (!empty($cv['compatibility'])) : ?>

            <div class="tf-score">

                <small>Compatibility</small>

                <div>

                    🎯 <?= esc_html($cv['compatibility']['score']) ?>%

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>

<div class="tf-info-grid">
<div class="tf-info-card"><strong>📧 Email</strong><p><?= esc_html($cv['candidate']['email']) ?></p></div>
<div class="tf-info-card"><strong>📞 Phone</strong><p><?= esc_html($cv['candidate']['phone']) ?></p></div>
<div class="tf-info-card"><strong>📍 Location</strong><p><?= esc_html($cv['candidate']['location']) ?></p></div>
<div class="tf-info-card"><strong>💼 Experience</strong><p><?= esc_html($cv['experience_years']) ?> years</p></div>
</div>

<div class="tf-card">
<h3>Summary</h3>
<p><?= esc_html($cv['summary']) ?></p>

<h3>🛠 Skills</h3>
<div>
<?php foreach ($cv['skills'] as $skill) : ?>
<span class="tf-badge"><?= esc_html($skill) ?></span>
<?php endforeach; ?>
</div>
</div>

<?php if (!empty($cv['compatibility'])) : ?>
<div class="tf-card">
<h3>🎯 Job Compatibility</h3>
<p><strong><?= esc_html($cv['compatibility']['score']) ?>%</strong></p>

<h4>✅ Matching Skills</h4>
<div>
<?php foreach ($cv['compatibility']['matching_skills'] as $skill) : ?>
<span class="tf-badge"><?= esc_html($skill) ?></span>
<?php endforeach; ?>
</div>

<h4>❌ Missing Skills</h4>
<div>
<?php foreach ($cv['compatibility']['missing_skills'] as $skill) : ?>
<span class="tf-badge tf-badge-missing"><?= esc_html($skill) ?></span>
<?php endforeach; ?>
</div>

<h4>💪 Strengths</h4>
<ul>
<?php foreach ($cv['compatibility']['strengths'] as $strength) : ?>
<li><?= esc_html($strength) ?></li>
<?php endforeach; ?>
</ul>

<h4>📈 Recommendations</h4>
<ul>
<?php foreach ($cv['compatibility']['recommendations'] as $recommendation) : ?>
<li><?= esc_html($recommendation) ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>

<?php endif; ?>
<?php endif; ?>
</div>
