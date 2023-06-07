USE db_78634029;

CREATE TABLE users (
    userId int NOT NULL AUTO_INCREMENT,
    email varchar(255) NOT NULL,
    name varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    gender varchar(255),
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (userId)
);

INSERT INTO users (email, name, password, gender) VALUES ('vader@dark.force', 'darth vader', '12345', 'male');
INSERT INTO users (email, name, password, gender) VALUES
('johndoe@example.com', 'John Doe', 'password123', 'Male'),
('janesmith@example.com', 'Jane Smith', 'securepassword', 'Female'),
('bobsmith@example.com', 'Bob Smith', '12345', 'Male'),
('360@dev.ca', 'dev', 'prod123', 'unknown');

CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  post_id INT NOT NULL,
  comment_text TEXT NOT NULL,
  time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(userId)
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author_id INT NOT NULL,
  picture VARCHAR(255),
  tags VARCHAR(255),
  post_text TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES users(userId)
);

INSERT INTO posts (title, author_id, picture, tags) VALUES
('Turkey', 4, '../blog/img/5.png', 'Travel'),
('No Bake Cake', 3, '../blog/img/2.png', 'Cooking'),
('DIY Doorstopper', 2, '../blog/img/3.png', 'DIY'),
('Kite Runner Review', 3, '../blog/img/1.png', 'Books'),
('Favourite Hiking Spot', 1, '../blog/img/2.png', 'Travel'),
('Best Books', 2, '../blog/img/1.png', 'Books');

UPDATE posts
SET post_text = "Turkey is a popular poultry choice around the world, and for good reason. Not only is it delicious, but it's also a great source of lean protein. Turkey can be prepared in a variety of ways, from roasted to grilled to fried. One popular way to enjoy turkey is during Thanksgiving, where it's often the star of the meal. Whether you're a fan of turkey sandwiches or prefer to have it as a main dish, there's no denying that turkey is a versatile and tasty meat."
WHERE title = 'Turkey';

UPDATE posts
SET post_text = "If you're looking for a quick and easy dessert that doesn't require an oven, a no-bake cake is a great option. With just a few simple ingredients, you can create a delicious cake that's perfect for any occasion. Some popular no-bake cake flavors include chocolate, vanilla, and strawberry. Plus, because there's no need to bake the cake, it's a great option for hot summer days when you don't want to turn on the oven."
WHERE title = 'No Bake Cake';

UPDATE posts
SET post_text = "A DIY doorstopper is a fun and easy project that can add a personal touch to your home. With just a few materials, you can create a doorstopper that's both functional and stylish. Some popular materials to use include fabric, rope, and even old books. Not only is a DIY doorstopper a great way to keep your doors open, but it can also serve as a conversation starter when guests come over."
WHERE title = 'DIY Doorstopper';

UPDATE posts
SET post_text = "The Kite Runner is a novel by Khaled Hosseini that has become a modern classic. The book follows the story of Amir, a young boy growing up in Afghanistan, and his complicated relationship with his friend Hassan. The book explores themes of friendship, betrayal, and redemption, and has become a popular choice for book clubs and classroom discussions. If you're looking for a thought-provoking and emotional read, The Kite Runner is definitely worth checking out."
WHERE title = 'Kite Runner Review';

UPDATE posts
SET post_text = "If you're someone who enjoys spending time in nature, finding a favorite hiking spot is a must. Whether it's a local trail or a national park, there's nothing quite like getting outside and exploring the world around you. Some popular hiking spots include the Grand Canyon, Yosemite National Park, and the Appalachian Trail. Of course, your favorite spot will depend on your personal preferences and location, but regardless of where you go, hiking is a great way to stay active and enjoy the beauty of nature."
WHERE title = 'Favourite Hiking Spot';

UPDATE posts
SET post_text = "While it's impossible to know what the future will hold, there are always plenty of great books to look forward to. In 2023, some highly anticipated books include 'The Four Winds' by Kristin Hannah, 'The Paper Palace' by Miranda Cowley Heller, and 'Beautiful World, Where Are You' by Sally Rooney. Whether you're a fan of fiction, non-fiction, or memoirs, there's sure to be a book coming out in 2023 that will capture your interest."
WHERE title = 'Best Books';

INSERT INTO comments (user_id, post_id, comment_text) VALUES
(2, 5, 'I visited that same spot a few months ago and absolutely loved it. The views were breathtaking!'),
(2, 5, 'Thanks for sharing this recommendation. I\'ve been looking for a new hiking spot to try out, and this sounds perfect.'),
(1, 5, 'I\'ve been going to that spot for years and it never gets old. Glad to hear that others are discovering it too!');

INSERT INTO comments (user_id, post_id, comment_text) VALUES
(1, 6, 'I\'ve read a few of these and agree that they were fantastic. I\'ll have to check out the others on your list!'),
(1, 6, 'Thanks for sharing your favorites. I\'ve been looking for some new books to read and this list is super helpful.'),
(2, 6, 'I actually didn\'t enjoy a few of these books, but I\'m glad you found them enjoyable!');

INSERT INTO comments (user_id, post_id, comment_text) VALUES (1, 1, 'I love turkey, it is one of my favourite meals!');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (2, 1, 'I agree, turkey is great, especially during the holidays.');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (3, 1, 'I don\'t really like turkey, I prefer chicken.');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (4, 1, 'Turkey is okay, but it can be a bit dry sometimes.');

INSERT INTO comments (user_id, post_id, comment_text) VALUES (1, 2, 'This no bake cake recipe is so easy and delicious!');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (2, 2, 'I can\'t wait to try making this cake!');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (3, 2, 'I don\'t like cake, but this recipe looks interesting.');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (4, 2, 'I prefer baked cakes, but this recipe sounds good too.');

INSERT INTO comments (user_id, post_id, comment_text) VALUES (1, 3, 'I never thought of making a doorstopper myself, great idea!');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (2, 3, 'This DIY project is perfect for a rainy day!');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (3, 3, 'I don\'t need a doorstopper, but I might make this for fun.');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (4, 3, 'I\'m not very handy, but maybe I can try making this.');

INSERT INTO comments (user_id, post_id, comment_text) VALUES (1, 4, 'The Kite Runner is one of my favourite books!');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (2, 4, 'I just finished reading The Kite Runner, it was amazing.');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (3, 4, 'I haven\'t read The Kite Runner, but now I want to.');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (4, 4, 'I\'m not really into books, but maybe I should give this one a try.');

INSERT INTO comments (user_id, post_id, comment_text) VALUES (1, 5, 'My favourite hiking spot is in the mountains, the view is amazing!');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (2, 5, 'I prefer hiking in the forest, it\'s more peaceful.');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (3, 5, 'I don\'t really like hiking, but I can appreciate the scenery.');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (4, 5, 'I haven\'t been hiking before, but maybe I should try it.');

INSERT INTO comments (user_id, post_id, comment_text) VALUES (1, 6, 'Great list of books, I\'ve read most of them!');
INSERT INTO comments (user_id, post_id, comment_text) VALUES (2, 6, 'I\'m always looking for new books to read!');
