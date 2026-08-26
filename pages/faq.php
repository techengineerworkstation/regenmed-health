<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<style>
.faq-section { max-width: 800px; margin: 0 auto; padding: 2rem 1.5rem; position: relative; z-index: 1; }
.faq-hero { text-align: center; margin-bottom: 2.5rem; }
.faq-hero h1 { font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem; background: linear-gradient(135deg, var(--accent-green), var(--accent-violet)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.faq-hero p { font-size: 0.9rem; color: var(--text-secondary); max-width: 550px; margin: 0 auto; line-height: 1.7; }

.faq-category { margin-bottom: 2rem; }
.faq-category-title { display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--border-color); }
.faq-category-title i { font-size: 1rem; }

.faq-item { border: 1px solid var(--border-color); border-radius: 12px; margin-bottom: 0.65rem; background: var(--bg-secondary); overflow: hidden; transition: all 0.2s ease; }
.faq-item:hover { border-color: var(--accent-primary); }
.faq-question { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; cursor: pointer; font-size: 0.82rem; font-weight: 600; color: var(--text-primary); background: none; border: none; width: 100%; text-align: left; }
.faq-question i { font-size: 1rem; color: var(--text-secondary); transition: transform 0.2s ease; flex-shrink: 0; margin-left: 0.75rem; }
.faq-item.open .faq-question i { transform: rotate(180deg); color: var(--accent-green); }
.faq-answer { padding: 0 1.25rem 1rem; font-size: 0.78rem; color: var(--text-secondary); line-height: 1.7; display: none; }
.faq-item.open .faq-answer { display: block; }
.faq-answer ul { list-style: none; padding: 0; margin: 0.5rem 0 0; }
.faq-answer ul li { padding: 0.2rem 0; display: flex; align-items: flex-start; gap: 0.4rem; }
.faq-answer ul li::before { content: '→'; color: var(--accent-green); font-weight: 700; flex-shrink: 0; }

.faq-cta { text-align: center; padding: 2rem; border-radius: 16px; background: linear-gradient(135deg, var(--accent-green), var(--accent-violet)); color: #fff; margin-top: 2rem; }
.faq-cta h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; }
.faq-cta p { font-size: 0.82rem; opacity: 0.9; margin-bottom: 1rem; }
.faq-cta-links { display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap; }
.faq-cta-link { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.55rem 1.1rem; border-radius: 10px; font-size: 0.78rem; font-weight: 600; text-decoration: none; transition: all 0.2s ease; }
.faq-cta-whatsapp { background: #25d366; color: #fff; }
.faq-cta-telegram { background: #0088cc; color: #fff; }
.faq-cta-email { background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3); }
</style>

<div class="faq-section">
  <div class="faq-hero">
    <h1>Frequently Asked Questions</h1>
    <p>Everything you need to know about Coach & Heal, our counselling programs, regenerative therapies, and medical diagnostics.</p>
  </div>

  <!-- COACHING -->
  <div class="faq-category">
    <div class="faq-category-title"><i class="lucide-heart-handshake" style="color:var(--accent-green)"></i> Counselling Programs</div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">What is life counselling and how is it different from therapy?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Life counselling focuses on your future — helping you set goals, overcome obstacles, and create actionable plans for growth. Therapy typically addresses past trauma and mental health conditions. Coach Ibe's approach combines both: forward-looking counselling grounded in wellness science, helping you achieve clarity, confidence, and purpose.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">How do counselling sessions work — online or in-person?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>We offer both formats:</p>
        <ul>
          <li><strong>Online sessions</strong> — via WhatsApp video call, Telegram, or Zoom. Available worldwide, any timezone.</li>
          <li><strong>In-person sessions</strong> — available across Nigeria (Lagos, Abuja, Port Harcourt, and other cities).</li>
          <li><strong>Hybrid packages</strong> — combine online counselling with periodic in-person check-ins.</li>
        </ul>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">How many sessions will I need?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Every person is different. Most clients see noticeable improvement within 4-6 sessions. We offer:</p>
        <ul>
          <li><strong>Discovery Session</strong> — free, 30 minutes, no obligation</li>
          <li><strong>Single Session</strong> — for specific questions or challenges</li>
          <li><strong>4-Week Program</strong> — structured counselling with weekly sessions</li>
          <li><strong>12-Week Transformation</strong> — deep, lasting change with progress tracking</li>
          <li><strong>Ongoing Support</strong> — monthly check-ins for continued growth</li>
        </ul>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">What topics can Coach Ibe help with?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Coach Ibe specializes in:</p>
        <ul>
          <li>Goal setting and life direction</li>
          <li>Confidence and self-esteem building</li>
          <li>Health optimization and chronic pain management</li>
          <li>Stress reduction and emotional regulation</li>
          <li>Career transitions and professional growth</li>
          <li>Relationship improvement</li>
          <li>Post-injury recovery and rehabilitation mindset</li>
          <li>Personal wellness and regenerative health guidance</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- REGENERATIVE MEDICINE -->
  <div class="faq-category">
    <div class="faq-category-title"><i class="lucide-dna" style="color:var(--accent-violet)"></i> Regenerative Medicine</div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">What is PEMF therapy and is it safe?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>PEMF (Pulsed Electromagnetic Field) therapy uses low-frequency electromagnetic pulses to stimulate cellular repair. It's:</p>
        <ul>
          <li><strong>FDA-cleared</strong> for depression, bone healing, and post-surgical recovery</li>
          <li><strong>Non-invasive</strong> — no needles, no pain, no side effects</li>
          <li><strong>Evidence-based</strong> — supported by over 2,000 clinical studies</li>
          <li>Used by NASA for astronaut recovery and by Olympic athletes for performance</li>
        </ul>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">How does stem cell therapy work?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Stem cell therapy uses your body's own regenerative cells to repair damaged tissue. The process:</p>
        <ul>
          <li><strong>Harvest</strong> — cells collected from bone marrow or adipose tissue (your own body)</li>
          <li><strong>Process</strong> — concentrated and prepared in a clinical setting</li>
          <li><strong>Inject</strong> — delivered precisely to the damaged area using imaging guidance</li>
          <li><strong>Heal</strong> — stem cells differentiate into healthy tissue, reducing inflammation and promoting repair</li>
        </ul>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">What conditions can regenerative medicine treat?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Regenerative therapies are effective for:</p>
        <ul>
          <li><strong>Joint problems</strong> — osteoarthritis, meniscus tears, ligament injuries</li>
          <li><strong>Spine conditions</strong> — herniated discs, degenerative disc disease</li>
          <li><strong>Chronic pain</strong> — back pain, neck pain, neuropathy</li>
          <li><strong>Sports injuries</strong> — tendonitis, rotator cuff, Achilles</li>
          <li><strong>Fertility</strong> — male and female factor infertility</li>
          <li><strong>Eye conditions</strong> — macular degeneration, diabetic retinopathy</li>
          <li><strong>Autoimmune</strong> — lupus, rheumatoid arthritis, Crohn's</li>
        </ul>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">How long do results take?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Results vary by condition and individual:</p>
        <ul>
          <li><strong>PEMF therapy</strong> — many feel improvement after 1-2 sessions; full benefits in 8-12 weeks</li>
          <li><strong>Stem cell therapy</strong> — initial improvement in 2-4 weeks; continued healing for 6-12 months</li>
          <li><strong>Nutritional optimization</strong> — energy and mood improvements within 1-2 weeks</li>
          <li><strong>Counselling</strong> — mindset shifts often occur in the first session; behavioral change in 4-6 weeks</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- DIAGNOSTICS -->
  <div class="faq-category">
    <div class="faq-category-title"><i class="lucide-scan" style="color:var(--accent-primary)"></i> Medical Diagnostics</div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">How does the AI scan analysis work?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Upload your MRI, CT, X-ray, or retinal scan through our secure portal. Our AI system:</p>
        <ul>
          <li>Analyzes the image using trained medical imaging models</li>
          <li>Identifies key findings and potential abnormalities</li>
          <li>Generates a detailed report with severity scoring</li>
          <li>Provides recommendations and next steps</li>
          <li>Your scan is reviewed by qualified specialists for validation</li>
        </ul>
        <p style="margin-top:0.5rem"><strong>Important:</strong> AI analysis is for educational and informational purposes. Always consult your physician for medical decisions.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">What scan types do you support?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>We support multiple imaging modalities:</p>
        <ul>
          <li><strong>MRI</strong> — brain, spine, knee, shoulder, hip, ankle</li>
          <li><strong>CT Scan</strong> — chest, abdomen, pelvis, head</li>
          <li><strong>X-Ray</strong> — skeletal, chest, dental</li>
          <li><strong>Retinal Imaging</strong> — OCT, fundus photos</li>
          <li><strong>Ultrasound</strong> — abdominal, pelvic, scrotal</li>
          <li><strong>Fertility Assessments</strong> — semen analysis, hormonal panels</li>
          <li><strong>Prostate Assessment</strong> — mpMRI, PSA correlation</li>
        </ul>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">Is my medical data safe and private?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Absolutely. Your privacy is our top priority:</p>
        <ul>
          <li><strong>HIPAA-aware</strong> — we follow strict health data protection standards</li>
          <li><strong>No data selling</strong> — we never sell, share, or monetize your information</li>
          <li><strong>Encrypted storage</strong> — all data is encrypted at rest and in transit</li>
          <li><strong>User control</strong> — you can delete your data at any time</li>
          <li><strong>Minimal collection</strong> — we only collect what's needed for your analysis</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- PRACTICAL -->
  <div class="faq-category">
    <div class="faq-category-title"><i class="lucide-info" style="color:#f59e0b"></i> Practical Information</div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">How much do sessions cost?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>We believe in accessible healthcare. Our pricing:</p>
        <ul>
          <li><strong>Discovery Session</strong> — FREE (no obligation)</li>
          <li><strong>Single Counselling Session</strong> — affordable per-session rate</li>
          <li><strong>4-Week Program</strong> — discounted package rate</li>
          <li><strong>12-Week Transformation</strong> — best value, includes all support</li>
          <li><strong>Diagnostic Analysis</strong> — per-scan pricing, varies by complexity</li>
          <li><strong>PEMF/Stem Cell Protocols</strong> — custom pricing based on treatment plan</li>
        </ul>
        <p style="margin-top:0.5rem">Contact Coach Ibe directly for current rates and package options.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">Where are you located?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Coach & Heal operates in two ways:</p>
        <ul>
          <li><strong>Online</strong> — serving clients worldwide via WhatsApp, Telegram, and video calls</li>
          <li><strong>In-person</strong> — available across Nigeria including Lagos, Abuja, Port Harcourt, Enugu, and other cities</li>
        </ul>
        <p style="margin-top:0.5rem">For in-person appointments, contact us to schedule at a location near you.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">How do I get started?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Getting started is simple:</p>
        <ul>
          <li><strong>Step 1:</strong> Send a message via WhatsApp (+234 701 074 4142), Telegram, or email (Ibe@coachandheal.store)</li>
          <li><strong>Step 2:</strong> Book your free discovery session</li>
          <li><strong>Step 3:</strong> Discuss your goals, challenges, and health history with Coach Ibe</li>
          <li><strong>Step 4:</strong> Receive a personalized plan — counselling, diagnostics, or therapy</li>
          <li><strong>Step 5:</strong> Begin your transformation journey</li>
        </ul>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-question" onclick="this.parentElement.classList.toggle('open')">Do you accept health insurance?<i class="lucide-chevron-down"></i></button>
      <div class="faq-answer">
        <p>Currently, Coach & Heal operates on a direct-pay model. This allows us to keep costs transparent and avoid the administrative overhead of insurance processing. Many clients find our rates significantly more affordable than traditional clinical visits. We're exploring insurance partnerships for the future.</p>
      </div>
    </div>
  </div>

  <!-- CTA -->
  <div class="faq-cta">
    <h3>Still Have Questions?</h3>
    <p>Reach out to Coach Ibe directly — we're happy to answer any questions about our programs, diagnostics, or regenerative therapies.</p>
    <div class="faq-cta-links">
      <a href="https://wa.me/2347010744142?text=Hi%20Coach%20Ibe!%20I%20have%20a%20question..." class="faq-cta-link faq-cta-whatsapp"><i class="lucide-message-circle"></i> WhatsApp</a>
      <a href="https://t.me/coachandheal" class="faq-cta-link faq-cta-telegram"><i class="lucide-send"></i> Telegram</a>
      <a href="mailto:Ibe@coachandheal.store" class="faq-cta-link faq-cta-email"><i class="lucide-mail"></i> Email</a>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.faq-question').forEach(btn => {
  btn.addEventListener('click', () => {
    const item = btn.parentElement;
    const wasOpen = item.classList.contains('open');
    // Close all in same category
    item.closest('.faq-category')?.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
    if (!wasOpen) item.classList.add('open');
  });
});
</script>
