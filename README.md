# DES - [Data Encryption Standard] Algorithm
# How DES Works in Detail
  -----------------------
DES is a block cipher
--meaning it operates on plaintext blocks of a given size (64-bits) and returns cipher text blocks of the same size. Thus DES results in a
permutation among the 2^64 (read this as: "2 to the 64th power") possible arrangements of 64 bits, each of which may be either 0 or 1. Each block of 64 bits is dividedinto two blocks of 32 bits each, a left half block L and a right half R.(This division is only used in certainoperations.)
Example:
-------
Let,
M be the plain text message,
M = NEVRQUIT
Plain text in ASCII: 78 69 86 82 81 85 73 84
Plain text in Hexad: 4e 45 56 52 51 55 49 54
M = 01001110 01000101 01010110 01010010 01010001 01010101 01001001 01010100

Here Two haves,
L = 01001110 01000101 01010110 01010010
R = 01010001 01010101 01001001 01010100
