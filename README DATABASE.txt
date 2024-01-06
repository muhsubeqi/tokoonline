table user
- id
- username (string)
- email (string)
- password (string)
- address (string)
- phone (string)
- gender (enum => L, P)
- birthday (date)
- role (enum => admin, supplier, member)

table categories
- id
- slug (string)
- icon (string)
- name (string)
- parent_id
	- foreign parent_id on categories
- users_id
	- foreign users_id on users

table product
- id
- photo (string)
- name (string)
- description (string)
- stock (integer)
- price (integer)
- categories_id
	- foreign categories_id on categories
- users_id
	-foreign users_id on users

table transaction
- id
- code (string)
- users_id 
	- foreign users_id on users
- products_id
	- foreign products_id on products
- qty (integer)
- subtotal (integer)
- name
- address
- portal_code (integer)
- ekspedisi (enum => TIKI, JNE, POS)
- status (enum => 0, 1)
