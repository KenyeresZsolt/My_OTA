<div class="container">
  <div class="text-center">
    <h2 class="section-heading text-uppercase">Kapcsolat</h2>
    <h3 class="section-subheading text-muted">Írd meg észrevételedet.</h3>
  </div>

  <?php if ($params['info'] === "kuldesSikeres") : ?>
    <a href="/kapcsolat" style="text-decoration:none">
      <div class="alert alert-success text-center">
        Küldés sikeres!
      </div>
    </a>
  <?php elseif($params['info'] === "emptyValue"): ?>
    <a href="/kapcsolat" style="text-decoration:none">
      <div class="alert alert-danger text-center">
          Tölts ki minden mezőt!
      </div>
    </a>
<?php endif; ?>

  <form id="contactForm" action="/submit-mail" method="POST">
    <div class="row align-items-stretch mb-5">
      <div class="col-md-6">
        <div class="form-group">
          <input class="form-control" name="name" type="text" placeholder="Név" required />
        </div>
        <div class="form-group">
          <input class="form-control" name="email" type="email" placeholder="Email cím" required />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group form-group-textarea mb-md-0">
          <textarea class="form-control" name="content" placeholder="Küldj üzenetet..." required></textarea>
        </div>
      </div>
    </div>

    <div class="text-center">
      <button class="btn btn-primary btn-xl text-uppercase" id="submitButton" type="submit">Küldés</button>
    </div>
  </form>
</div>