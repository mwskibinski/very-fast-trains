##lst = [1, 10, 100, 1000]
##
##lst[len(lst) : ] = [5000]
##
##print(lst)
##
##lst.append(6000)
##
##print(lst)
##
##lst.insert(1, 999)
##
##print(lst)
##
##tmp = lst.pop()
##
##print(lst, tmp)
##
##lst.clear()
##print(lst)
##

##lst = [-5, -1, -4, -11, 888, 45, -11, 33]
##print(lst.index(-11))
##print(lst.index(-11, 3))
##print(lst.index(-11, 4))
####print(lst.index(-11, 7))
##
##lst.sort()
##lst.sort(reverse = True)
##print(lst)

##foo = [None, 123, "bar"]
##print(foo)
##foo.sort()
##print(foo)

##from collections import deque
##
##queue = deque(["Eric", "John", "Michael"])
##queue.append("Terry")
##queue.append("Graham")
##queue.popleft()
##queue.popleft()
##queue

##squares = []
##for x in range(10):
##    squares.append(x ** 2)
##
##print(squares)
####print(x)
##
##squares = list(map(lambda x: x ** 2, range(10)))
##print(squares)
##
##squares = [x ** 2 for x in range(10)]
##print(squares)
##
####print(map(lambda x: x ** 2, range(10)))

##print(
##    [(x, y)
##     for x in [1, 2, 3]
##     for y in [3, 1, 4]
##     if x != y]
##)
##
##combs = []
##for x in [1,2,3]:
##    for y in [3,1,4]:
##        if x != y:
##            combs.append((x, y))
##print(combs)

##vec = [-4, -2, 0, 2, 4]
##print([x * 2 for x in vec])
##
##from math import pi
##print(
##    [str(round(pi,i)) for i in range(1,6)]
##)

##matrix = [
##    [1,2,3,4],
##    [5,6,7,8],
##    [9,10,11,12],
##]
##print(matrix)
##
##print(
##    [[row[i] for row in matrix] for i in range(4)]
##)
##
##transposed = []
##for i in range(4):
##    transposed.append([row[i] for row in matrix])
##
##print(transposed)
##
##print(list(zip(*matrix)))

t = 12345, 54321, 'hello!'
t2 = (12345, 54321, 'hello!')

##print(t)
##print(t2)

##u = t, (1, 2, 3, 4, 5)
##print(u)
##
##y = t, 1, 2, 3, 4, 5
##
##print(y)
##

##t[0] = 88888

v = [1,2,3], [3,2,1]
##print(v)

##v[0] = [5,6,7]
v[0][0] = 888
v[0].append(999)

##print(v)

##empty = ()
##print(empty)
##
##singleton = 'hello',
##print(len(empty))
##print(len(singleton))
##
##print(singleton)
##
##x, y, z = t

##basket = {'apple', 'orange', 'apple', 'pear', 'orange', 'banana'}
##print(basket)
##print('orange' in basket)
##print('crabgrass' in basket)
##
##a = set('abracadabra')
##b = set('alacazam')
##
##print(a)
##print(b)
##print()
##print(a - b)
##print(a | b)
##print(a & b)
##print(a ^ b)
####print(a / b)
####print(a + b)

a = {x for x in 'abracadabra' if x not in 'abc'}
