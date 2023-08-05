<div class="center">
    <div class="row">
        <h3 class="blue-text">
            Contatc Us
        </h3>
        <form action="<?= site_url('/contact') ?>" method="post" class="col s12">
            <p class="input-field">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" placeholder="Muhammad Ashraf" required="required">
            </p>
            <p class="input-field">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="valid@mail.com" required="required">
            </p>
            <p class="input-field">
                <label for="message">Message</label>
                <textarea name="message" id="message" class="materialize-textarea" required="required" placeholder="Hi there ..... I contact you for.."></textarea>
            </p>
            <button type="submit" name="contact_submit" value="1" class="bold btn-large waves-effect">✉️ Send Message</button>
        </form>
    </div>
</div>

