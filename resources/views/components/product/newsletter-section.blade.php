        <section class="newsletter-section">

            <div class="container">
                <h3> Subscribe to our newsletter for exclusive promotions and research updates</h3>
                <form action="{{ route('newsletter.subscribe') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="name" class="newsletter-input" placeholder="First Name">
                        </div>
                        <div class="col-md-3">
                            <input type="email" name="email" class="newsletter-input" placeholder="Email Address">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="contact_number" class="newsletter-input"
                                placeholder="Contact Number">

                        </div>
                        <div class="col-md-3">
                            <button class="newsletter-button">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
