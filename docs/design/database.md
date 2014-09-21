### User document

``` js
{
	id: 1,
	username: "username",
	password: "hashed pass",               // OPTIONAL
	email: "user@email.com",
	mobile: "09xxxxxxxxx",
	sn_id: "44529208921",                  // Social network unique id
	sn_type: "facebook",                   // Social network type
	status: 1,                             // 1: active, 0: locked
	last_login: "2014-09-21 15:02:23",
	created_date: "2014-09-21 15:02:23",
	modified_date: "2014-09-21 15:02:23",
}
```

### Admin User document

``` js
{
	id: 1,
	username: "username",
	password: "hashed pass",               // OPTIONAL
	role: "super_admin",
	fullname: "SSS Admin",
	email: "admin@email.com",
	mobile: "09xxxxxxxxx",
	status: 1,                             // 1: active, 0: locked
	last_login: "2014-09-21 15:02:23",
	created_date: "2014-09-21 15:02:23",
	modified_date: "2014-09-21 15:02:23",
}
```

### Post document

``` js
{
	id: 1,
	title: "Post title",
	type: "image",                         // image, video, text
	display_content: "image url",          // OPTIONAL. html content if post is text, embeded html if post is video
	original_content: "image url",         // Original image/video url which user post
	status: 1,                             // 1: review_pending, 2: active, 0: blocked
	sticky: true                           // post always appears on top of homepage, tag page, category page
	tag: [                                 // array of tag
		"football", "fun", "relax", "news"
	],
	comment_count: 12,
	like_count: 13,
	created_by: user_ref,
	created_date: "2014-09-21 15:02:23",
	modified_date: "2014-09-21 15:02:23",
}
```
