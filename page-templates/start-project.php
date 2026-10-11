<?php
/**
 * Template Name: Start a Project
 * Template Post Type: page
 *
 * All copy for the Start a project (contact) page lives in this file. The
 * form is handled by inc/contact-form.php. Styling lives in
 * assets/css/contact.css and behavior in assets/js/contact.js, loaded only
 * for this template.
 *
 * @package iweb
 * @since 1.10.0
 */

$iweb_status = isset( $_GET['iweb_contact'] ) ? sanitize_key( wp_unslash( $_GET['iweb_contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$iweb_notices = array(
	'sent'    => array( 'success', __( 'Thank you! Your enquiry has been sent. We\'ll get back to you within 1 business day.', 'iweb' ) ),
	'invalid' => array( 'error', __( 'Please check the required fields and try again.', 'iweb' ) ),
	'spam'    => array( 'error', __( 'Please wait a minute before sending another enquiry.', 'iweb' ) ),
	'upload'  => array( 'error', __( 'We couldn\'t accept an attachment. Files must be under 10MB and a common document or image type.', 'iweb' ) ),
	'failed'  => array( 'error', __( 'Sorry, we couldn\'t send your enquiry. Please email us directly instead.', 'iweb' ) ),
);

$iweb_promises = array(
	array( 'chat', __( 'Quick response', 'iweb' ), __( 'We usually reply within 1 business day.', 'iweb' ) ),
	array( 'users', __( 'Expert consultation', 'iweb' ), __( 'Get practical advice for your goals.', 'iweb' ) ),
	array( 'doc', __( 'Clear proposal', 'iweb' ), __( 'Timeline and transparent pricing.', 'iweb' ) ),
	array( 'shield', __( 'No obligation', 'iweb' ), __( 'Start with a free discussion.', 'iweb' ) ),
);

$iweb_next = array(
	array( __( 'We review your enquiry', 'iweb' ), __( 'We\'ll go through your requirements and get back to you within 1 business day.', 'iweb' ) ),
	array( __( 'Discovery call', 'iweb' ), __( 'We\'ll schedule a short call to understand your goals, challenges and expectations in detail.', 'iweb' ) ),
	array( __( 'Proposal and plan', 'iweb' ), __( 'You\'ll receive a tailored proposal with scope, timeline and cost estimate.', 'iweb' ) ),
	array( __( 'Get started', 'iweb' ), __( 'Once everything looks good, we kick off the project and keep you updated at every step.', 'iweb' ) ),
);

$iweb_faqs = array(
	array( __( 'How soon can you start?', 'iweb' ), __( 'We typically start new projects within 1–2 weeks, depending on the scope and requirements.', 'iweb' ) ),
	array( __( 'Do you work with international clients?', 'iweb' ), __( 'Yes, we work with clients across the globe and are fully remote-friendly.', 'iweb' ) ),
	array( __( 'Can you help with existing websites?', 'iweb' ), __( 'Absolutely. We can audit, optimize or extend your existing website or application.', 'iweb' ) ),
	array( __( 'Do you offer ongoing support?', 'iweb' ), __( 'Yes, we provide ongoing maintenance and support plans to keep your website and systems running smoothly.', 'iweb' ) ),
);

$iweb_email    = iweb_contact_email();
$iweb_profiles = iweb_get_social_profiles();

get_header();
?>

<main id="primary" class="site-main contact" tabindex="-1">

	<!-- Hero -->
	<section class="contact-hero">
		<div class="container contact-hero__inner">
			<div>
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'iweb' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'iweb' ); ?></a> ›
					<span aria-current="page"><?php esc_html_e( 'Start a project', 'iweb' ); ?></span>
				</nav>
				<p class="eyebrow"><?php esc_html_e( 'Start a project', 'iweb' ); ?></p>
				<h1 class="contact-hero__title"><?php esc_html_e( 'Let\'s build something great', 'iweb' ); ?> <span class="accent"><?php esc_html_e( 'together.', 'iweb' ); ?></span></h1>
				<p class="contact-hero__lead"><?php esc_html_e( 'Tell us about your project and we\'ll get back to you with a clear plan, timeline and estimate. Whether it\'s a new website, SEO, automation or custom development, we\'re here to help.', 'iweb' ); ?></p>

				<ul class="promises">
					<?php foreach ( $iweb_promises as $iweb_p ) : ?>
						<li>
							<span class="promises__icon"><?php echo iweb_icon( $iweb_p[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<strong><?php echo esc_html( $iweb_p[1] ); ?></strong>
							<span><?php echo esc_html( $iweb_p[2] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="contact-hero__visual" aria-hidden="true">
				<div class="contact-hero__screen"><p><?php esc_html_e( 'Your Project Starts Here', 'iweb' ); ?></p></div>
			</div>
		</div>
	</section>

	<!-- Form and next steps -->
	<section id="enquiry" class="container contact-main">
		<div class="contact-form-card">
			<h2><?php esc_html_e( 'Tell us about your project', 'iweb' ); ?></h2>
			<p class="contact-form-card__sub"><?php esc_html_e( 'Fill in the details below and we\'ll get back to you soon.', 'iweb' ); ?></p>

			<?php if ( isset( $iweb_notices[ $iweb_status ] ) ) : ?>
				<div class="notice notice--<?php echo esc_attr( $iweb_notices[ $iweb_status ][0] ); ?>" role="<?php echo 'success' === $iweb_notices[ $iweb_status ][0] ? 'status' : 'alert'; ?>">
					<?php echo esc_html( $iweb_notices[ $iweb_status ][1] ); ?>
				</div>
			<?php endif; ?>

			<form class="contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="iweb_contact">
				<?php wp_nonce_field( 'iweb_contact', 'iweb_contact_nonce' ); ?>

				<div class="field-hp" aria-hidden="true">
					<label for="iweb_hp"><?php esc_html_e( 'Leave this field empty', 'iweb' ); ?></label>
					<input type="text" id="iweb_hp" name="iweb_hp" tabindex="-1" autocomplete="off">
				</div>

				<div class="field">
					<label for="cf-name"><?php esc_html_e( 'Your name', 'iweb' ); ?> <span aria-hidden="true">*</span></label>
					<input type="text" id="cf-name" name="name" placeholder="<?php esc_attr_e( 'Full name', 'iweb' ); ?>" autocomplete="name" required>
				</div>
				<div class="field">
					<label for="cf-email"><?php esc_html_e( 'Email address', 'iweb' ); ?> <span aria-hidden="true">*</span></label>
					<input type="email" id="cf-email" name="email" placeholder="you@company.com" autocomplete="email" required>
				</div>
				<div class="field">
					<label for="cf-company"><?php esc_html_e( 'Company name', 'iweb' ); ?></label>
					<input type="text" id="cf-company" name="company" placeholder="<?php esc_attr_e( 'Company name (optional)', 'iweb' ); ?>" autocomplete="organization">
				</div>
				<div class="field">
					<label for="cf-website"><?php esc_html_e( 'Website', 'iweb' ); ?></label>
					<input type="url" id="cf-website" name="website" placeholder="https://" autocomplete="url">
				</div>
				<div class="field">
					<label for="cf-type"><?php esc_html_e( 'Project type', 'iweb' ); ?> <span aria-hidden="true">*</span></label>
					<select id="cf-type" name="project_type" required>
						<option value=""><?php esc_html_e( 'Select a service', 'iweb' ); ?></option>
						<?php foreach ( iweb_contact_project_types() as $iweb_opt ) : ?>
							<option value="<?php echo esc_attr( $iweb_opt ); ?>"><?php echo esc_html( $iweb_opt ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="field">
					<label for="cf-budget"><?php esc_html_e( 'Budget range', 'iweb' ); ?></label>
					<select id="cf-budget" name="budget">
						<option value=""><?php esc_html_e( 'Select budget range', 'iweb' ); ?></option>
						<?php foreach ( iweb_contact_budgets() as $iweb_opt ) : ?>
							<option value="<?php echo esc_attr( $iweb_opt ); ?>"><?php echo esc_html( $iweb_opt ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="field field--full">
					<label for="cf-details"><?php esc_html_e( 'Project details', 'iweb' ); ?> <span aria-hidden="true">*</span></label>
					<textarea id="cf-details" name="details" rows="5" placeholder="<?php esc_attr_e( 'Tell us about your project, goals, current challenges and any specific requirements...', 'iweb' ); ?>" required></textarea>
				</div>
				<div class="field field--full">
					<label for="cf-files"><?php esc_html_e( 'Attachments (optional)', 'iweb' ); ?></label>
					<label class="dropzone" for="cf-files" data-dropzone>
						<?php echo iweb_icon( 'clip' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><strong><?php esc_html_e( 'Click to upload files', 'iweb' ); ?></strong> <?php esc_html_e( 'or drag and drop', 'iweb' ); ?></span>
						<small><?php esc_html_e( 'You can attach project briefs, reference links or any documents (up to 3 files, max 10MB per file)', 'iweb' ); ?></small>
						<span class="dropzone__names" data-file-names></span>
					</label>
					<input type="file" id="cf-files" name="attachments[]" multiple class="screen-reader-text">
				</div>
				<div class="field field--full">
					<button type="submit" class="btn btn--light"><?php esc_html_e( 'Submit project enquiry', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
				</div>
			</form>
		</div>

		<div class="contact-side">
			<div class="next-card">
				<h2><?php esc_html_e( 'What happens next?', 'iweb' ); ?></h2>
				<ol class="next-steps">
					<?php foreach ( $iweb_next as $iweb_n ) : ?>
						<li>
							<h3><?php echo esc_html( $iweb_n[0] ); ?></h3>
							<p><?php echo esc_html( $iweb_n[1] ); ?></p>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>

			<div class="side-card">
				<h3><?php esc_html_e( 'Not sure what you need?', 'iweb' ); ?></h3>
				<p><?php esc_html_e( 'No problem. Book a free audit call and we\'ll help you identify the right solution for your business.', 'iweb' ); ?></p>
				<a class="btn btn--outline btn--sm" href="<?php echo esc_url( $iweb_email ? 'mailto:' . $iweb_email . '?subject=' . rawurlencode( __( 'Free audit call', 'iweb' ) ) : '#enquiry' ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			</div>

			<div class="side-card side-card--row">
				<div>
					<h3><?php esc_html_e( 'Prefer to email us directly?', 'iweb' ); ?></h3>
					<p><?php esc_html_e( 'You can also reach us at:', 'iweb' ); ?></p>
					<?php if ( $iweb_email ) : ?>
						<a class="side-card__email" href="<?php echo esc_url( 'mailto:' . $iweb_email ); ?>"><?php echo iweb_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( $iweb_email ); ?></a>
					<?php endif; ?>
				</div>
				<?php if ( $iweb_profiles ) : ?>
					<div>
						<h3><?php esc_html_e( 'Follow us', 'iweb' ); ?></h3>
						<ul class="social-links social-links--dark">
							<?php foreach ( $iweb_profiles as $iweb_profile ) : ?>
								<li><a href="<?php echo esc_url( $iweb_profile['url'] ); ?>"><?php echo iweb_icon( $iweb_profile['network'] ) ? iweb_icon( $iweb_profile['network'] ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text"><?php echo esc_html( $iweb_profile['label'] ); ?></span></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- FAQ -->
	<section class="section contact-faq">
		<div class="container">
			<div class="contact-faq__head">
				<h2 class="section-title"><?php esc_html_e( 'Frequently asked questions', 'iweb' ); ?></h2>
				<p><?php esc_html_e( 'Still have questions? Feel free to reach out and we\'ll be happy to help.', 'iweb' ); ?></p>
			</div>
			<div class="contact-faq__list">
				<?php foreach ( $iweb_faqs as $iweb_faq ) : ?>
					<details class="contact-faq__item">
						<summary><?php echo esc_html( $iweb_faq[0] ); ?> <?php echo iweb_icon( 'chevron' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></summary>
						<p><?php echo esc_html( $iweb_faq[1] ); ?></p>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Closing CTA -->
	<section class="section section--dark cta-band contact-cta">
		<div class="container contact-cta__inner">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Ready to take the next step?', 'iweb' ); ?></p>
				<h2><?php esc_html_e( 'Let\'s turn your ideas into real results.', 'iweb' ); ?></h2>
			</div>
			<div class="cta-row">
				<a class="btn btn--light" href="#enquiry"><?php esc_html_e( 'Start a project', 'iweb' ); ?> <?php echo iweb_icon( 'arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<a class="btn btn--ghost-dark" href="<?php echo esc_url( $iweb_email ? 'mailto:' . $iweb_email : '#enquiry' ); ?>"><?php echo iweb_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php esc_html_e( 'Book a free audit call', 'iweb' ); ?></a>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
