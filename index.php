<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <title>Qui Occasions</title>

    <!-- Icons -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- Styles -->
    <!-- Bootsrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"> -->

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Custom -->
    <link href="/assets/css/main.css" rel="stylesheet" />
  </head>
  <body>
    <section class="landing-page">
      <div class="left-page">
        <div class="logo-wrapper">
          <img src="/assets/img/logo.png" alt="Main Logo" />
        </div>
      </div>
      <div class="right-page">
        <nav class="navbar navbar-expand-lg navbar-light navbar-qui">
          <div class="container-fluid">
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarNav"
              aria-controls="navbarNav"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div
              class="collapse navbar-collapse justify-content-end"
              id="navbarNav"
            >
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#upcoming_events">Events</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#contacts">Contact</a>
                </li>
                <li class="nav-item">
                  <a class="btn btn-primary" href="/auth/login.php"
                    >Getting Started</a
                  >
                </li>
              </ul>
            </div>
          </div>
        </nav>

        <section class="landing-page-wrapper">
          <!-- Header -->

          <div id="home">
            <div class="mb-5">
              <h1
                class="lh-lg m-0 mb-3"
                style="font-size: 50px; font-weight: 600"
              >
                <span>THROW AN EVENT YOU'LL</span> <br />
                <span>NEVER FORGET</span>
              </h1>

              <p class="lh-lg m-0" style="width: 400px">
                We treat your event like a Business with a comprehensive plan to
                ensure that you event is delivered on time and on budget.
              </p>
            </div>

            <div class="services d-flex align-items-start">
              <div class="d-flex align-items-start services-item">
                <figure class="services-item-img">
                  <img
                    width="70"
                    height="70"
                    src="https://secureservercdn.net/198.71.233.33/i6c.6ec.myftpupload.com/wp-content/uploads/2020/12/Group-68.png?time=1643261167"
                    class="attachment-full size-full"
                    alt=""
                    loading="lazy"
                  />
                </figure>
                <div>
                  <h2 class="services-item-title text-uppercase">
                    Event Design
                  </h2>

                  <p>
                    There are many variations of passages of Lorem Ipsum
                    available, but the majority have suffered alteration in some
                    form, by injected humour.
                  </p>
                </div>
              </div>

              <div class="d-flex align-items-start services-item">
                <figure class="services-item-img">
                  <img
                    width="70"
                    height="70"
                    src="https://secureservercdn.net/198.71.233.33/i6c.6ec.myftpupload.com/wp-content/uploads/2020/12/Group-69.png?time=1643261167"
                    class="attachment-full size-full"
                    alt="planning"
                    loading="lazy"
                  />
                </figure>
                <div>
                  <h2 class="services-item-title text-uppercase">Planning</h2>

                  <p>
                    There are many variations of passages of Lorem Ipsum
                    available, but the majority have suffered alteration in some
                    form, by injected humour.
                  </p>
                </div>
              </div>

              <div class="d-flex align-items-start services-item">
                <figure class="services-item-img">
                  <img
                    width="70"
                    height="70"
                    src="https://secureservercdn.net/198.71.233.33/i6c.6ec.myftpupload.com/wp-content/uploads/2020/12/Group-70.png?time=1643261167"
                    class="attachment-full size-full"
                    alt="logistics"
                    loading="lazy"
                  />
                </figure>
                <div>
                  <h2 class="services-item-title text-uppercase">Logistics</h2>

                  <p>
                    There are many variations of passages of Lorem Ipsum
                    available, but the majority have suffered alteration in some
                    form, by injected humour.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Upcoming Events -->

          <div id="upcoming_events">
            <div
              id="carouselExampleControls"
              class="carousel slide upcoming-events"
              data-bs-ride="carousel"
            >
              <div class="d-flex justify-content-between mb-3">
                <div>
                  <h2>Upcoming Events</h2>
                </div>

                <div>
                  <button
                    class="btn btn-primary mb-3 mr-1"
                    data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev"
                    role="button"
                  >
                    <i class="fa fa-arrow-left"></i>
                  </button>
                  <button
                    class="btn btn-primary mb-3"
                    data-bs-target="#carouselExampleControls"
                    data-bs-slide="next"
                    role="button"
                    data-slide="next"
                  >
                    <i class="fa fa-arrow-right"></i>
                  </button>
                </div>
              </div>

              <div class="carousel-inner">
                <div class="carousel-item active">
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <div class="card" style="border-radius: 16px">
                        <img
                          class="img-fluid"
                          style="
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                          "
                          alt="100%x280"
                          src="https://images.unsplash.com/photo-1532781914607-2031eca2f00d?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=7c625ea379640da3ef2e24f20df7ce8d"
                        />
                        <div class="card-body">
                          <h4 class="card-title">Special title treatment</h4>
                          <p class="card-text">
                            With supporting text below as a natural lead-in to
                            additional content.
                          </p>

                          <div>
                            <button class="btn btn-primary">Reserve</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div class="card" style="border-radius: 16px">
                        <img
                          class="img-fluid"
                          style="
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                          "
                          alt="100%x280"
                          src="https://images.unsplash.com/photo-1517760444937-f6397edcbbcd?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=42b2d9ae6feb9c4ff98b9133addfb698"
                        />
                        <div class="card-body">
                          <h4 class="card-title">Special title treatment</h4>
                          <p class="card-text">
                            With supporting text below as a natural lead-in to
                            additional content.
                          </p>
                          <div>
                            <button class="btn btn-primary">Reserve</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div class="card" style="border-radius: 16px">
                        <img
                          class="img-fluid"
                          style="
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                          "
                          alt="100%x280"
                          src="https://images.unsplash.com/photo-1532712938310-34cb3982ef74?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=3d2e8a2039c06dd26db977fe6ac6186a"
                        />
                        <div class="card-body">
                          <h4 class="card-title">Special title treatment</h4>
                          <p class="card-text">
                            With supporting text below as a natural lead-in to
                            additional content.
                          </p>

                          <div>
                            <button class="btn btn-primary">Reserve</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <div class="card" style="border-radius: 16px">
                        <img
                          class="img-fluid"
                          style="
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                          "
                          alt="100%x280"
                          src="https://images.unsplash.com/photo-1532771098148-525cefe10c23?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=3f317c1f7a16116dec454fbc267dd8e4"
                        />
                        <div class="card-body">
                          <h4 class="card-title">Special title treatment</h4>
                          <p class="card-text">
                            With supporting text below as a natural lead-in to
                            additional content.
                          </p>

                          <div>
                            <button class="btn btn-primary">Reserve</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div class="card" style="border-radius: 16px">
                        <img
                          class="img-fluid"
                          style="
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                          "
                          alt="100%x280"
                          src="https://images.unsplash.com/photo-1532715088550-62f09305f765?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=ebadb044b374504ef8e81bdec4d0e840"
                        />
                        <div class="card-body">
                          <h4 class="card-title">Special title treatment</h4>
                          <p class="card-text">
                            With supporting text below as a natural lead-in to
                            additional content.
                          </p>

                          <div>
                            <button class="btn btn-primary">Reserve</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div class="card" style="border-radius: 16px">
                        <img
                          class="img-fluid"
                          style="
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                          "
                          alt="100%x280"
                          src="https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=0754ab085804ae8a3b562548e6b4aa2e"
                        />
                        <div class="card-body">
                          <h4 class="card-title">Special title treatment</h4>
                          <p class="card-text">
                            With supporting text below as a natural lead-in to
                            additional content.
                          </p>

                          <div>
                            <button class="btn btn-primary">Reserve</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <div class="card" style="border-radius: 16px">
                        <img
                          class="img-fluid"
                          style="
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                          "
                          alt="100%x280"
                          src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=ee8417f0ea2a50d53a12665820b54e23"
                        />
                        <div class="card-body">
                          <h4 class="card-title">Special title treatment</h4>
                          <p class="card-text">
                            With supporting text below as a natural lead-in to
                            additional content.
                          </p>

                          <div>
                            <button class="btn btn-primary">Reserve</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div class="card" style="border-radius: 16px">
                        <img
                          class="img-fluid"
                          style="
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                          "
                          alt="100%x280"
                          src="https://images.unsplash.com/photo-1532777946373-b6783242f211?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=8ac55cf3a68785643998730839663129"
                        />
                        <div class="card-body">
                          <h4 class="card-title">Special title treatment</h4>
                          <p class="card-text">
                            With supporting text below as a natural lead-in to
                            additional content.
                          </p>

                          <div>
                            <button class="btn btn-primary">Reserve</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <div class="card" style="border-radius: 16px">
                        <img
                          class="img-fluid"
                          style="
                            border-top-left-radius: 16px;
                            border-top-right-radius: 16px;
                          "
                          alt="100%x280"
                          src="https://images.unsplash.com/photo-1532763303805-529d595877c5?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=1080&amp;fit=max&amp;ixid=eyJhcHBfaWQiOjMyMDc0fQ&amp;s=5ee4fd5d19b40f93eadb21871757eda6"
                        />
                        <div class="card-body">
                          <h4 class="card-title">Special title treatment</h4>
                          <p class="card-text">
                            With supporting text below as a natural lead-in to
                            additional content.
                          </p>

                          <div>
                            <button class="btn btn-primary">Reserve</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End of events -->

          <!-- Contact Form -->
          <div class="contacts" id="contacts">
            <div class="contacts-wrapper">
              <div class="contact-details">
                <h2 class="mb-3">Get a quote</h2>
                <p class="mb-5">Fill up the form and our Team will get back to you with 24 hours.</p>

                <div style="width: 280px;">
                  <div class="contact-item">
                    <p class="p-0 m-0"><span class="icon"><i class="fas fa-phone" style="transform: rotate(90deg);"></i></span> <span>(+254)722 000000</span></p>
                  </div>
                  <div class="contact-item">
                    <p class="p-0 m-0"><span class="icon"><i class="fas fa-envelope"></i></span> <span>(+254)722 000000</span></p>
                  </div>
                  <div class="contact-item">
                    <p class="p-0 m-0"><span class="icon"><i class="fas fa-map-marker-alt"></i></span> <span>Imenti Bld, Nairobi. Kenya</span></p>
                  </div>
                </div>
              </div>

              <div class="contacts-form">
                <form class="contact-form">
                  <div class="mb-4 form-floating">
                    <input type="text" class="form-control" placeholder="Enter Full Name" id="floatingFullName">
                    <label for="floatingFullName">Your Name</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="Enter Email">
                    <label for="floatingInput">Your Email</label>
                  </div>
                  <div class="form-floating mb-5">
                    <textarea class="form-control" placeholder="Enter your comments here" id="floatingTextarea" style="height: 150px"></textarea>
                    <label for="floatingTextarea">Comments</label>
                  </div>
                  <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-auth">
                      Send Message <i class="far fa-paper-plane"></i>
                    </button>
                  </div>

                </form>
              </div>
            </div>
          </div>
          <!-- End Contact Form -->
        </section>
      </div>
    </section>

    <!-- Template Main JS File -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/assets/js/main.js"></script>

    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  </body>
</html>
