<style type="text/css">
    #right{
        float:right;
        background-color:white;
        width:255px;
        height:750px;
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        -khtml-border-radius: 20px;
        margin-right:-270px;
        text-align:center;
    }
    .about {
        width:400px;
        text-align:left;
    }
    .photo {
        margin-top:-140px;
        margin-left:490px;
    }
</style>
<div id="right">
    <h2>Find what's new.</h2>
    <script src="http://widgets.twimg.com/j/2/widget.js"></script>
    <script>
        new TWTR.Widget({
            version: 2,
            type: 'profile',
            rpp: 4,
            interval: 2000,
            width: 225,
            height: 250,
            theme: {
                shell: {
                    background: '#333333',
                    color: '#ffffff'
                },
                tweets: {
                    background: '#000000',
                    color: '#ffffff',
                    links: '#4aed05'
                }
            },
            features: {
                scrollbar: true,
                loop: false,
                live: true,
                hashtags: true,
                timestamp: true,
                avatars: false,
                behavior: 'default'
            }
        }).render().setUser('swiftsharing').start();
    </script>
    <h2>SwiftSharing Statics</h2>
    <p>
        <em>
            <b>Total Registered Members:</b>
        </em>
        <?php echo intval(Model_Member::getTotalCount()) ?>
    </p>
    <p>
        <em>
            <b>Total Posts: </b>
        </em>
        <?php echo intval(Model_Blab::getTotalCount()) ?>
    </p>
    <p>
        <em>
            <b>Total Friend Relationships: </b>
        </em>
        <?php echo intval(Model_Relationship::getTotalCount()) ?>
    </p>
    <p>
        <em>
            <b>Total Likes/Dislikes: </b>
        </em>
        <?php echo intval(Model_Like::getTotalCount()) ?>
    </p>
</div>
<div class="about">
    <h2>Alaxic smith</h2>
    <p>Alaxic is a Freshman IB Student at Longview High School, in Longview, Tx. He is 15, and loves to code. He is the founder of SwiftSharing and the CEO.  He attended Foster Middle School where he was in Robotics.</p>
    <div class="about">
        <h2>Paul Henry</h2>
        <p>Paul is a Junior, and Home Schooled in Longview, Tx. He met Alaxic while volunteering at Foster Middle School for the Robotics Team. He works at SwiftSharing as the Lead Software Engineer, and is a Co-Founder. </p>
    </div>
    <div class="about">
        <h2>Nickson Ariemba</h2>
        <p>Nickson is a Junior from Kenya, Africa and moved to the United States 6 years ago. He plays Soccer, goes to Rosemont High School, and loves web developing. Nickson and Alaxic met on DevelopPHP, a website when Alaxic needed some guidance. Nickson builds Linux’s Os’ in his free time. He works at SwiftSharing as a Co-founder and COO.</p>
    </div>
    <div class="about">
        <h2>Neil Parikh</h2>

        <p>Neil is an Almeda High School graduate and is currently attending Diablo Valley College. He is 18, and a Business Major. He lives in Berkeley, California, and met Alaxic through Nickson. He is the current CFO.</p>
    </div>
    <div class="about">
        <h2>Spencer Smith</h2>
        <p>Spencer Smith is a frehsman who is the current Chief Marketing Officer of SwiftSharing. He came into contact with the company through a prior project, The LikeBench.</p>
    </div>
    <div class="about">
        <h2>Magan Tyler</h2>
        <p>Magan is 16, is a Sophomore, and attends Longview High School where she is a Pre-AP student. She has helped with numerous things with the site such as testing, communicating with our users, and keeping the team motivated. She currently serves as the Lead Documenter, User Experience Manager, and is a Co-Founder.</p>
    </div>
</div>


