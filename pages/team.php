<?php if (!VERCEL_MODE && session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<style>
.about-section { max-width: 900px; margin: 0 auto; padding: 2rem 1.5rem; position: relative; z-index: 1; }
.about-hero { text-align: center; margin-bottom: 2.5rem; }
.about-hero h1 { font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem; background: linear-gradient(135deg, var(--accent-green), var(--accent-violet)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
.about-hero p { font-size: 0.9rem; color: var(--text-secondary); max-width: 600px; margin: 0 auto; line-height: 1.7; }

.coach-card { display: grid; grid-template-columns: 280px 1fr; gap: 2rem; padding: 2rem; border-radius: 16px; background: var(--bg-secondary); border: 1px solid var(--border-color); margin-bottom: 2.5rem; }
.coach-photo { position: relative; overflow: hidden; border-radius: 14px; }
.coach-photo img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 14px; }
.coach-photo-placeholder { width: 100%; aspect-ratio: 3/4; border-radius: 14px; background: linear-gradient(135deg, var(--accent-green), var(--accent-violet)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 3rem; font-weight: 800; }
.coach-info h2 { font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin-bottom: 0.25rem; }
.coach-info .coach-title { font-size: 0.8rem; color: var(--accent-green); font-weight: 600; margin-bottom: 0.75rem; }
.coach-info .coach-bio { font-size: 0.8rem; color: var(--text-secondary); line-height: 1.7; margin-bottom: 1rem; }
.coach-credentials { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem; }
.credential-badge { padding: 0.3rem 0.7rem; border-radius: 8px; font-size: 0.68rem; font-weight: 600; background: var(--bg-tertiary); color: var(--text-secondary); border: 1px solid var(--border-color); }
.credential-badge.green { background: color-mix(in srgb, var(--accent-green) 10%, transparent); color: var(--accent-green); border-color: color-mix(in srgb, var(--accent-green) 20%, transparent); }
.credential-badge.violet { background: color-mix(in srgb, var(--accent-violet) 10%, transparent); color: var(--accent-violet); border-color: color-mix(in srgb, var(--accent-violet) 20%, transparent); }
.coach-contact { display: flex; flex-direction: column; gap: 0.35rem; }
.coach-contact a { display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: var(--text-secondary); text-decoration: none; }
.coach-contact a:hover { color: var(--accent-primary); }

.mission-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2.5rem; }
.mission-card { padding: 1.5rem; border-radius: 14px; background: var(--bg-secondary); border: 1px solid var(--border-color); text-align: center; transition: all 0.2s ease; }
.mission-card:hover { border-color: var(--accent-primary); box-shadow: var(--shadow-md); }
.mission-card-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin: 0 auto 0.85rem; }
.mission-card h3 { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.35rem; }
.mission-card p { font-size: 0.75rem; color: var(--text-secondary); line-height: 1.6; }

.values-list { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-bottom: 2.5rem; }
.value-item { display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem; border-radius: 12px; background: var(--bg-secondary); border: 1px solid var(--border-color); }
.value-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
.value-item h4 { font-size: 0.8rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.2rem; }
.value-item p { font-size: 0.7rem; color: var(--text-secondary); line-height: 1.5; }

.timeline { position: relative; padding-left: 2rem; margin-bottom: 2.5rem; }
.timeline::before { content: ''; position: absolute; left: 8px; top: 0; bottom: 0; width: 2px; background: var(--border-color); }
.timeline-item { position: relative; margin-bottom: 1.5rem; padding: 1rem 1.25rem; border-radius: 12px; background: var(--bg-secondary); border: 1px solid var(--border-color); }
.timeline-item::before { content: ''; position: absolute; left: -1.6rem; top: 1.25rem; width: 12px; height: 12px; border-radius: 50%; background: var(--accent-green); border: 2px solid var(--bg-secondary); }
.timeline-year { font-size: 0.65rem; font-weight: 700; color: var(--accent-green); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.25rem; }
.timeline-title { font-size: 0.85rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.2rem; }
.timeline-desc { font-size: 0.73rem; color: var(--text-secondary); line-height: 1.5; }

.cta-section { padding: 2rem; border-radius: 16px; background: linear-gradient(135deg, var(--accent-green), var(--accent-violet)); color: #fff; text-align: center; margin-bottom: 2rem; }
.cta-section h2 { font-size: 1.2rem; font-weight: 800; margin-bottom: 0.5rem; }
.cta-section p { font-size: 0.82rem; opacity: 0.9; margin-bottom: 1rem; }
.cta-links { display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap; }
.cta-link { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.25rem; border-radius: 10px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s ease; }
.cta-whatsapp { background: #25d366; color: #fff; }
.cta-whatsapp:hover { background: #1da851; }
.cta-telegram { background: #0088cc; color: #fff; }
.cta-telegram:hover { background: #006fa3; }
.cta-email { background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3); }
.cta-email:hover { background: rgba(255,255,255,0.3); }

@media (max-width: 768px) {
  .coach-card { grid-template-columns: 1fr; }
  .mission-grid { grid-template-columns: 1fr; }
  .values-list { grid-template-columns: 1fr; }
}
</style>

<div class="about-section">
  <!-- Hero -->
  <div class="about-hero">
    <h1>About Coach & Heal</h1>
    <p>We combine the science of regenerative medicine with the art of personal counselling to help you heal, grow, and thrive — physically, mentally, and emotionally.</p>
  </div>

  <!-- Coach Ibe Card -->
  <div class="coach-card">
    <div class="coach-photo">
      <div class="coach-photo-placeholder">CI</div>
    </div>
    <div class="coach-info">
      <h2>Coach Ibe</h2>
      <div class="coach-title">Founder & Lead Wellness Coach — Ibereal Enterprise</div>
      <div class="coach-bio">
        Coach Ibe is a certified wellness coach, regenerative health advocate, and founder of Coach & Heal — the wellness division of Ibereal Enterprise. With deep expertise in life counselling, health optimization, PEMF therapy, stem cell protocols, and medical diagnostics, Coach Ibe has helped over 500 people across Nigeria and worldwide transform their health, mindset, and quality of life.
        <br><br>
        Coach Ibe's approach is rooted in the belief that true healing addresses the whole person — mind, body, and spirit. Whether you're recovering from injury, optimizing performance, or seeking direction in life, Coach Ibe provides personalized guidance backed by cutting-edge science and compassionate care.
      </div>
      <div class="coach-credentials">
        <span class="credential-badge green">Certified Wellness Coach</span>
        <span class="credential-badge violet">Regenerative Medicine Advocate</span>
        <span class="credential-badge green">PEMF Therapy Specialist</span>
        <span class="credential-badge violet">Stem Cell Protocol Advisor</span>
        <span class="credential-badge green">Medical Diagnostics Expert</span>
        <span class="credential-badge violet">Ibereal Enterprise Founder</span>
      </div>
      <div class="coach-contact">
        <a href="https://wa.me/2347010744142"><i class="lucide-phone" style="font-size:0.9rem;color:var(--accent-green)"></i> +234 701 074 4142 (WhatsApp)</a>
        <a href="mailto:Ibe@coachandheal.store"><i class="lucide-mail" style="font-size:0.9rem;color:var(--accent-primary)"></i> Ibe@coachandheal.store</a>
        <a href="https://t.me/coachandheal"><i class="lucide-send" style="font-size:0.9rem;color:var(--accent-violet)"></i> Telegram: @coachandheal</a>
        <a href="https://coachandheal.store"><i class="lucide-globe" style="font-size:0.9rem;color:#f59e0b"></i> coachandheal.store</a>
      </div>
    </div>
  </div>

  <!-- Mission Cards -->
  <div style="text-align:center;margin-bottom:1.25rem;">
    <h2 style="font-size:1.1rem;font-weight:700;color:var(--text-primary);"><i class="lucide-target" style="color:var(--accent-green);font-size:1.1rem;"></i> Our Mission</h2>
  </div>
  <div class="mission-grid">
    <div class="mission-card">
      <div class="mission-card-icon" style="background:color-mix(in srgb, var(--accent-green) 12%, transparent);color:var(--accent-green)"><i class="lucide-heart-handshake"></i></div>
      <h3>Empower Growth</h3>
      <p>We empower individuals to take control of their health and life journey through personalized counselling, education, and support.</p>
    </div>
    <div class="mission-card">
      <div class="mission-card-icon" style="background:color-mix(in srgb, var(--accent-violet) 12%, transparent);color:var(--accent-violet)"><i class="lucide-microscope"></i></div>
      <h3>Advance Healing</h3>
      <p>Leveraging cutting-edge regenerative medicine — PEMF, stem cells, and AI diagnostics — to accelerate healing and recovery.</p>
    </div>
    <div class="mission-card">
      <div class="mission-card-icon" style="background:color-mix(in srgb, var(--accent-primary) 12%, transparent);color:var(--accent-primary)"><i class="lucide-globe"></i></div>
      <h3>Reach Everyone</h3>
      <p>Making world-class health counselling and diagnostics accessible online worldwide and in-person across Nigeria.</p>
    </div>
  </div>

  <!-- Core Values -->
  <div style="text-align:center;margin-bottom:1.25rem;">
    <h2 style="font-size:1.1rem;font-weight:700;color:var(--text-primary);"><i class="lucide-compass" style="color:var(--accent-violet);font-size:1.1rem;"></i> Our Core Values</h2>
  </div>
  <div class="values-list">
    <div class="value-item">
      <div class="value-icon" style="background:color-mix(in srgb, var(--accent-green) 12%, transparent);color:var(--accent-green)"><i class="lucide-shield-check"></i></div>
      <div><h4>Complete Confidentiality</h4><p>Your health data and counselling sessions are 100% private. We never sell, share, or store your information beyond what's needed for your care.</p></div>
    </div>
    <div class="value-item">
      <div class="value-icon" style="background:color-mix(in srgb, var(--accent-violet) 12%, transparent);color:var(--accent-violet)"><i class="lucide-brain"></i></div>
      <div><h4>Science-Backed Methods</h4><p>Every recommendation is rooted in peer-reviewed research, clinical evidence, and proven regenerative medicine protocols.</p></div>
    </div>
    <div class="value-item">
      <div class="value-icon" style="background:color-mix(in srgb, var(--accent-primary) 12%, transparent);color:var(--accent-primary)"><i class="lucide-users"></i></div>
      <div><h4>Personalized Care</h4><p>No cookie-cutter programs. Every counselling plan and diagnostic assessment is tailored to your unique body, goals, and life situation.</p></div>
    </div>
    <div class="value-item">
      <div class="value-icon" style="background:color-mix(in srgb, #f59e0b 12%, transparent);color:#f59e0b"><i class="lucide-hand-heart"></i></div>
      <div><h4>Compassionate Guidance</h4><p>We meet you where you are. No judgment, no pressure — just genuine support and expert guidance at every step of your journey.</p></div>
    </div>
  </div>

  <!-- Journey Timeline -->
  <div style="text-align:center;margin-bottom:1.25rem;">
    <h2 style="font-size:1.1rem;font-weight:700;color:var(--text-primary);"><i class="lucide-trending-up" style="color:var(--accent-green);font-size:1.1rem;"></i> Our Journey</h2>
  </div>
  <div class="timeline">
    <div class="timeline-item">
      <div class="timeline-year">2019</div>
      <div class="timeline-title">Ibereal Enterprise Founded</div>
      <div class="timeline-desc">Coach Ibe establishes Ibereal Enterprise with a vision to bridge the gap between traditional wellness counselling and cutting-edge regenerative medicine in Nigeria.</div>
    </div>
    <div class="timeline-item">
      <div class="timeline-year">2020</div>
      <div class="timeline-title">Life & Health Counselling Launch</div>
      <div class="timeline-desc">Formal counselling programs launch — helping individuals overcome limiting beliefs, optimize health, and build purposeful lives through structured sessions.</div>
    </div>
    <div class="timeline-item">
      <div class="timeline-year">2022</div>
      <div class="timeline-title">Regenerative Medicine Integration</div>
      <div class="timeline-desc">PEMF therapy, stem cell protocols, and nutritional medicine are integrated into the counselling framework — creating a truly holistic health platform.</div>
    </div>
    <div class="timeline-item">
      <div class="timeline-year">2024</div>
      <div class="timeline-title">AI-Powered Diagnostics</div>
      <div class="timeline-desc">Launch of AI-assisted medical imaging analysis — MRI, CT, X-ray, retinal, prostate, and fertility scans reviewed with cutting-edge machine learning.</div>
    </div>
    <div class="timeline-item">
      <div class="timeline-year">2025</div>
      <div class="timeline-title">Coach & Heal Platform</div>
      <div class="timeline-desc">Full platform launch: counselling programs, diagnostic tools, wellness resources, and regenerative health protocols — all in one place. 500+ people transformed.</div>
    </div>
  </div>

  <!-- CTA -->
  <div class="cta-section">
    <h2>Start Your Transformation Today</h2>
    <p>Book a free discovery session with Coach Ibe. No obligation, no pressure — just a genuine conversation about your goals.</p>
    <div class="cta-links">
      <a href="https://wa.me/2347010744142?text=Hi%20Coach%20Ibe!%20I%27d%20like%20to%20learn%20more%20about%20your%20counselling." class="cta-link cta-whatsapp"><i class="lucide-message-circle"></i> WhatsApp</a>
      <a href="https://t.me/coachandheal" class="cta-link cta-telegram"><i class="lucide-send"></i> Telegram</a>
      <a href="mailto:Ibe@coachandheal.store" class="cta-link cta-email"><i class="lucide-mail"></i> Email</a>
    </div>
  </div>
</div>
