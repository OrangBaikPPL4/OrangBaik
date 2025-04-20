<style>
    body { font-family: 'Inter', Arial, sans-serif; margin: 0; padding: 0; background: #f7fafc; color: #222; }
    a { text-decoration: none; color: inherit; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .section-title { color: #1976D2; font-size: 2em; font-weight: 700; margin-bottom: 18px; text-align: center; letter-spacing: 0.5px; }
    .section-subtitle { color: #555; font-size: 1.1em; text-align: center; margin-bottom: 36px; }
    .navbar { background: #fff; border-bottom: 1px solid #e6e6e6; display: flex; justify-content: space-between; align-items: center; padding: 14px 40px; position: sticky; top: 0; z-index: 10; box-shadow: 0 2px 12px #0001; }
    .navbar .logo { display: flex; align-items: center; font-size: 1.6em; font-weight: 700; color: #1976D2; letter-spacing: 1px; }
    .navbar img { height: 44px; margin-right: 12px; }
    .navbar nav a { margin: 0 14px; color: #222; font-weight: 600; font-size: 1.07em; transition: color 0.2s; padding: 6px 2px; }
    .navbar nav a:hover { color: #f59e1b; }
    .navbar .btn { background: #f59e1b; color: #fff; padding: 8px 24px; border-radius: 6px; text-decoration: none; margin-left: 12px; font-weight: 700; box-shadow: 0 2px 12px #f59e1b22; transition: background 0.2s; }
    .navbar .btn:hover { background: #d48514; }

    /* HERO 2 COLUMN */
    .hero-section { background: linear-gradient(90deg, #F6F9FF 60%, #1976D2 100%); padding: 60px 0 32px 0; }
    .hero-grid { display: flex; align-items: center; justify-content: center; gap: 48px; flex-wrap: wrap; }
    .hero-left { flex: 1 1 350px; min-width: 320px; }
    .hero-headline { font-size: 2.4em; font-weight: 700; color: #1976D2; margin-bottom: 12px; line-height: 1.15; }
    .hero-desc { font-size: 1.18em; color: #444; margin-bottom: 30px; }
    .hero-cta { background: #f59e1b; color: #fff; padding: 14px 38px; border-radius: 8px; font-size: 1.13em; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 2px 12px #f59e1b22; transition: background 0.2s; }
    .hero-cta:hover { background: #d48514; }
    .hero-right { flex: 1 1 350px; min-width: 320px; display: flex; justify-content: center; }
    .hero-img { width: 340px; max-width: 100%; border-radius: 16px; box-shadow: 0 4px 24px #1976d21a; }

    /* Statistik */
    .stats-row { display: flex; gap: 28px; justify-content: center; margin: 38px 0 0 0; flex-wrap: wrap; }
    .stat-box { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #0001; padding: 18px 32px; min-width: 160px; text-align: center; }
    .stat-title { color: #1976D2; font-size: 1.1em; font-weight: 600; margin-bottom: 2px; }
    .stat-value { font-size: 1.7em; font-weight: 700; color: #f59e1b; }

    /* Campaign Grid */
    .campaign-section { background: #fff; padding: 46px 0 18px 0; }
    .campaign-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px; }
    .campaign-card { background: #f8fafc; border-radius: 12px; box-shadow: 0 2px 12px #0001; display: flex; flex-direction: column; overflow: hidden; transition: box-shadow 0.2s; }
    .campaign-card:hover { box-shadow: 0 6px 24px #1976d233; }
    .campaign-img { width: 100%; height: 180px; object-fit: cover; }
    .campaign-body { padding: 18px 18px 14px 18px; flex: 1; display: flex; flex-direction: column; }
    .campaign-title { font-size: 1.15em; font-weight: 700; color: #1976D2; margin-bottom: 7px; }
    .campaign-desc { font-size: 0.98em; color: #444; margin-bottom: 12px; flex: 1; }
    .campaign-meta { font-size: 0.93em; color: #888; margin-bottom: 8px; }
    .campaign-actions { margin-top: 8px; }
    .campaign-btn { background: #f59e1b; color: #fff; padding: 7px 20px; border-radius: 6px; font-weight: 600; transition: background 0.2s; border: none; cursor: pointer; }
    .campaign-btn:hover { background: #d48514; }
    .campaign-badge { display: inline-block; background: #1976D2; color: #fff; font-size: 0.85em; border-radius: 6px; padding: 4px 12px; margin-bottom: 7px; }

    /* Fitur Utama */
    .fitur-section { background: #f6fafd; padding: 44px 0 18px 0; }
    .fitur-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 24px; max-width: 900px; margin: 0 auto; }
    .fitur-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #1976d211; padding: 34px 14px 26px 14px; text-align: center; }
    .fitur-icon { font-size: 2.3em; margin-bottom: 10px; }
    .fitur-title { font-weight: 700; color: #1976D2; margin-bottom: 7px; }
    .fitur-desc { color: #444; font-size: 0.97em; }

    /* Berita Grid */
    .berita-section { background: #fff; padding: 44px 0 18px 0; }
    .berita-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; }
    .berita-card { background: #f8fafc; border-radius: 10px; box-shadow: 0 2px 8px #1976d211; overflow: hidden; }
    .berita-img { width: 100%; height: 120px; object-fit: cover; }
    .berita-title { font-weight: 600; color: #1976D2; padding: 10px 14px 14px 14px; font-size: 1em; }

    /* Testimoni */
    .testimoni-section { background: #f6fafd; padding: 44px 0 18px 0; }
    .testimoni-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px; }
    .testimoni-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #0001; padding: 28px 22px; display: flex; flex-direction: column; align-items: flex-start; }
    .testimoni-quote { font-style: italic; color: #444; margin-bottom: 12px; }
    .testimoni-user { font-weight: 600; color: #1976D2; margin-top: 8px; }

    /* Footer */
    .footer { background: #1976D2; color: #fff; text-align: center; padding: 30px 0 20px 0; margin-top: 44px; }
    .footer .footer-links { margin-bottom: 12px; }
    .footer .footer-links a { color: #fff; margin: 0 10px; font-weight: 500; font-size: 1.05em; opacity: 0.9; }
    .footer .footer-links a:hover { text-decoration: underline; opacity: 1; }
    .footer-logo { display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2em; margin-bottom: 10px; }
    .footer-logo img { height: 32px; margin-right: 8px; }
    .footer-copy { font-size: 0.98em; color: #e0e7ef; margin-top: 8px; }

    @media (max-width: 900px) {
        .hero-grid { flex-direction: column; gap: 26px; }
    }
    @media (max-width: 700px) {
        .navbar { flex-direction: column; padding: 12px 8px; }
        .hero-section { padding: 34px 0 18px 0; }
        .container { padding: 0 7px; }
    }
</style>
