<?php include '../includes/header.php'; ?>

<main>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black shadow">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <img src="../public/img/event-img-3.jpg" class="object-fit-cover rounded-start" width="462" height="588" alt="Cosplay Event Img">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <h4 class="fw-bold mt-1 mb-5 pb-1"><i class="fa-solid fa-arrow-right-to-bracket me-3"></i>Login</h4>
                                </div>
                                <form>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form2Example11">Username</label>
                                        <input type="email" id="form2Example11" class="form-control"
                                            placeholder="John Doe" required>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="password">Password</label>
                                            <a class="text-muted" href="#">Forgot password?</a>
                                        </div>
                                        <input type="password" id="password" class="form-control" placeholder="********" required>
                                    </div>
                                    <div class="text-center pt-1 mb-4">
                                        <button class="btn btn-dark mb-3 w-100" type="button">Log in</button>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="mb-0 me-2">Don't have an account?
                                            <span><a href="signup.php">Sign Up</a></span>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>